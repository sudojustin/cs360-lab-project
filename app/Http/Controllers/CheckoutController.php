<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    // Step 1: Show the shipping information form
    public function shipping()
    {
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Get the authenticated user
        $user = auth()->user();
        
        // Get cart items and ensure quantities are integers
        $cartItems = Cart::getContent();
        
        // Log cart data for debugging
        \Log::info('Shipping page with cart data', [
            'cart_count' => $cartItems->count(),
            'cart_items' => $cartItems->toArray()
        ]);
        
        return view('checkout.shipping', [
            'user' => $user,
            'cart_items' => $cartItems,
            'cart_total' => Cart::getTotal()
        ]);
    }
    
    // Process shipping information
    public function processShipping(Request $request)
    {
        // Validate shipping information
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Store shipping data directly in the user model temporarily
        $user = auth()->user();
        $user->temp_data = json_encode([
            'shipping' => [
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'phone' => $request->phone
            ]
        ]);
        $user->save();
        
        // Log for debugging
        \Log::info('Shipping data stored in user model', [
            'user_id' => $user->id, 
            'shipping' => json_decode($user->temp_data, true)
        ]);
        
        // Proceed to payment method
        return redirect()->route('checkout.payment');
    }
    
    // Step 2: Payment method selection
    public function payment()
    {
        $user = auth()->user();
        $userData = json_decode($user->temp_data ?? '{}', true);
        
        // Get cart items and ensure quantities are integers
        $cartItems = Cart::getContent();
        
        // Debug logging
        \Log::info('Payment method called', [
            'user_id' => $user->id,
            'user_data' => $userData,
            'cart_count' => $cartItems->count(),
            'cart_items' => $cartItems->toArray()
        ]);
        
        // Show the payment form
        return view('checkout.payment', [
            'cart_items' => $cartItems,
            'cart_total' => Cart::getTotal()
        ]);
    }
    
    // Process payment method
    public function processPayment(Request $request)
    {
        // Validate payment information
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:credit_card',
            'card_number' => 'required|string|min:15|max:16',
            'card_name' => 'required|string|max:255',
            'expiry_month' => 'required|numeric|min:1|max:12',
            'expiry_year' => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 20),
            'cvv' => 'required|string|min:3|max:4',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Get user and current temp data
        $user = auth()->user();
        $userData = json_decode($user->temp_data ?? '{}', true);
        
        // Add payment data
        $userData['payment'] = [
            'payment_method' => $request->payment_method,
            'transaction_id' => 'SIM_' . strtoupper(substr(md5(uniqid()), 0, 6))
        ];
        
        // Store updated data
        $user->temp_data = json_encode($userData);
        $user->save();
        
        // Log for debugging
        \Log::info('Payment data stored in user model', [
            'user_id' => $user->id,
            'user_data' => $userData,
            'items_count' => Cart::getContent()->count()
        ]);
        
        // Proceed to review
        return redirect()->route('checkout.review');
    }
    
    // Step 3: Order review
    public function review()
    {
        // Get user data
        $user = auth()->user();
        $userData = json_decode($user->temp_data ?? '{}', true);
        
        // Get cart items and ensure quantities are integers
        $cartItems = Cart::getContent();
        
        // Debug session state
        \Log::info('Review method called', [
            'user_id' => $user->id,
            'user_data' => $userData,
            'cart_count' => $cartItems->count(),
            'cart_items' => $cartItems->toArray()
        ]);
        
        // Format address
        $shipping_address = '';
        if (!empty($userData['shipping'])) {
            $shipping = $userData['shipping'];
            $shipping_address = $shipping['name'] . "\n" . 
                               $shipping['address'] . "\n" . 
                               $shipping['city'] . ", " . $shipping['state'] . " " . $shipping['zip_code'] . "\n" .
                               "Phone: " . $shipping['phone'];
        }
        
        // Get payment method
        $payment_method = !empty($userData['payment']) ? $userData['payment']['payment_method'] : 'Credit Card';
        
        // Show the review page
        return view('checkout.review', [
            'cart_items' => $cartItems,
            'cart_total' => Cart::getTotal(),
            'shipping_address' => $shipping_address,
            'payment_method' => $payment_method
        ]);
    }
    
    // Process the order
    public function placeOrder()
    {
        // Get user data
        $user = auth()->user();
        $userData = json_decode($user->temp_data ?? '{}', true);
        
        // Debug session state
        \Log::info('PlaceOrder method called', [
            'user_id' => $user->id,
            'user_data' => $userData,
            'cart_count' => Cart::getContent()->count()
        ]);
        
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Validate data is present
        if (empty($userData['shipping']) || empty($userData['payment'])) {
            \Log::error('Missing shipping or payment data', [
                'user_id' => $user->id,
                'user_data' => $userData
            ]);
            return redirect()->route('checkout.shipping')
                ->with('error', 'Missing shipping or payment information. Please complete all checkout steps.');
        }
        
        // Get all cart items and verify each product is in stock
        $cartItems = Cart::getContent();
        
        foreach ($cartItems as $item) {
            $product = \App\Models\Product::find($item->id);
            
            if (!$product || $product->stock < $item->quantity) {
                return redirect()->route('cart.list')
                    ->with('error', 'Some items in your cart are no longer available in the requested quantity. Please update your cart.');
            }
        }

        // Format shipping address from user data
        $shipping = $userData['shipping'];
        $shipping_address = $shipping['name'] . "\n" . 
                          $shipping['address'] . "\n" . 
                          $shipping['city'] . ", " . $shipping['state'] . " " . $shipping['zip_code'] . "\n" .
                          "Phone: " . $shipping['phone'];

        // Get payment info from user data
        $payment = $userData['payment'];

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => Cart::getTotal(),
            'shipping_address' => $shipping_address,
            'payment_status' => 'completed',
            'payment_provider' => 'Credit Card',
            'payment_transaction_id' => $payment['transaction_id'],
            'placed_at' => now(),
        ]);

        // Add all products from the cart to the order with their original quantities
        foreach ($cartItems as $item) {
            $product = \App\Models\Product::find($item->id);
            
            // Make sure quantity is handled as integer
            $quantity = (int) $item->quantity;
            
            // Log the order item for debugging
            \Log::info('Adding product to order', [
                'product_id' => $item->id,
                'product_name' => $item->name,
                'quantity' => $quantity,
                'price' => $item->price,
                'quantity_type' => gettype($item->quantity)
            ]);
            
            // Attach product to order with quantity and price
            $order->products()->attach($item->id, [
                'quantity' => $quantity,
                'price' => $item->price,
            ]);
            
            // Reduce product stock
            $product->stock -= $quantity;
            $product->save();
        }

        // Clear the cart and temporary user data
        Cart::clear();
        $user->temp_data = null;
        $user->save();
        
        // Log successful order
        \Log::info('Order placed successfully', [
            'order_id' => $order->id,
            'user_id' => $user->id,
            'total' => $order->total_price,
            'products_count' => $cartItems->count()
        ]);

        // Redirect to confirmation page
        return redirect()->route('checkout.confirmation', ['order' => $order->id]);
    }
    
    // Step 4: Order confirmation
    public function confirmation($orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);
        
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('checkout.confirmation', [
            'order' => $order
        ]);
    }
} 