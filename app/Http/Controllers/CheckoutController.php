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
        
        return view('checkout.shipping', [
            'user' => $user,
            'cart_items' => Cart::getContent(),
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
        
        // Store shipping data - using the original full keys
        $shipping = [
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone
        ];
        
        session(['shipping_info' => $shipping]);
        
        // Log for debugging
        \Log::info('Shipping data stored', ['shipping' => $shipping]);
        
        // Proceed to payment method
        return redirect()->route('checkout.payment');
    }
    
    // Step 2: Payment method selection
    public function payment()
    {
        // Get the shipping info from session
        $shipping = session('shipping_info');
        
        // Debug logging
        \Log::info('Payment method called', [
            'shipping_info' => $shipping,
            'has_shipping_info' => session()->has('shipping_info'),
            'cart_count' => Cart::getContent()->count(),
            'cart_items' => Cart::getContent()->toArray(),
            'all_session' => session()->all()
        ]);
        
        // Don't redirect, just show the payment form regardless
        return view('checkout.payment', [
            'cart_items' => Cart::getContent(),
            'cart_total' => Cart::getTotal()
        ]);
    }
    
    // Process payment method
    public function processPayment(Request $request)
    {
        // Validate payment information (for format only - no actual processing)
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
        
        // Store payment data with full keys
        $paymentData = [
            'payment_method' => $request->payment_method,
            'transaction_id' => 'SIM_' . strtoupper(substr(md5(uniqid()), 0, 6))
        ];
        
        session(['payment_info' => $paymentData]);
        
        // Log for debugging
        \Log::info('Payment data stored', [
            'payment' => $paymentData,
            'items_count' => Cart::getContent()->count()
        ]);
        
        // Proceed to review
        return redirect()->route('checkout.review');
    }
    
    // Step 3: Order review
    public function review()
    {
        // Get session data
        $shipping = session('shipping_info');
        $payment = session('payment_info');
        
        // Debug session state
        \Log::info('Review method called', [
            'shipping_info' => $shipping,
            'payment_info' => $payment,
            'has_shipping' => session()->has('shipping_info'),
            'has_payment' => session()->has('payment_info'),
            'cart_count' => Cart::getContent()->count(),
            'all_session' => session()->all()
        ]);
        
        // Format address
        $shipping_address = '';
        if ($shipping) {
            $shipping_address = $shipping['name'] . "\n" . 
                               $shipping['address'] . "\n" . 
                               $shipping['city'] . ", " . $shipping['state'] . " " . $shipping['zip_code'] . "\n" .
                               "Phone: " . $shipping['phone'];
        }
        
        // Show the review page regardless of session state
        return view('checkout.review', [
            'cart_items' => Cart::getContent(),
            'cart_total' => Cart::getTotal(),
            'shipping_address' => $shipping_address,
            'payment_method' => $payment ? $payment['payment_method'] : 'Credit Card'
        ]);
    }
    
    // Process the order
    public function placeOrder()
    {
        // Debug session state
        \Log::info('PlaceOrder method called', [
            'shipping_info' => session('shipping_info'),
            'payment_info' => session('payment_info'),
            'has_shipping' => session()->has('shipping_info'),
            'has_payment' => session()->has('payment_info'),
            'cart_count' => Cart::getContent()->count(),
            'all_session' => session()->all()
        ]);
        
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Get session data
        $shipping = session('shipping_info', []);
        $payment = session('payment_info', []);
        
        // Validate data is present
        if (empty($shipping) || empty($payment)) {
            return redirect()->route('checkout.shipping')
                ->with('error', 'Missing shipping or payment information. Please complete all checkout steps.');
        }
        
        $user = auth()->user();
        
        // Get all cart items and verify each product is in stock
        $cartItems = Cart::getContent();
        
        foreach ($cartItems as $item) {
            $product = \App\Models\Product::find($item->id);
            
            if (!$product || $product->stock < $item->quantity) {
                return redirect()->route('cart.list')
                    ->with('error', 'Some items in your cart are no longer available in the requested quantity. Please update your cart.');
            }
        }

        // Format shipping address from session data
        $shipping_address = $shipping['name'] . "\n" . 
                          $shipping['address'] . "\n" . 
                          $shipping['city'] . ", " . $shipping['state'] . " " . $shipping['zip_code'] . "\n" .
                          "Phone: " . $shipping['phone'];

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => Cart::getTotal(),
            'shipping_address' => $shipping_address,
            'payment_status' => 'completed',
            'payment_provider' => 'Credit Card',
            'payment_transaction_id' => $payment['transaction_id'] ?? ('SIM_' . strtoupper(substr(md5(uniqid()), 0, 6))),
            'placed_at' => now(),
        ]);

        // Add all products from the cart to the order with their original quantities
        foreach ($cartItems as $item) {
            $product = \App\Models\Product::find($item->id);
            
            // Attach product to order with quantity and price
            $order->products()->attach($item->id, [
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
            
            // Reduce product stock
            $product->stock -= $item->quantity;
            $product->save();
        }

        // Clear the cart and checkout session data
        Cart::clear();
        session()->forget(['shipping_info', 'payment_info']);
        
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