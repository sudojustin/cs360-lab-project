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
        
        // Store shipping data in session
        $shipping = [
            'n' => $request->name,
            'a' => $request->address,
            'c' => $request->city,
            's' => $request->state,
            'z' => $request->zip_code,
            'p' => $request->phone
        ];
        
        // Store shipping data in session
        session()->put('cs', $shipping);
        session()->save();
        
        // Debug information
        \Log::info('Shipping data stored in session', ['shipping' => $shipping]);
        \Log::info('Cart contents', ['items' => Cart::getContent()->toArray()]);
        
        // Proceed to payment method
        return redirect()->route('checkout.payment');
    }
    
    // Step 2: Payment method selection
    public function payment()
    {
        // Check if shipping information is provided
        if (!session()->has('cs')) {
            return redirect()->route('checkout.shipping')->with('error', 'Please provide shipping information first.');
        }
        
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Get cart contents for display
        $cartItems = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        // Log for debugging
        \Log::info('Payment page cart contents', [
            'items_count' => $cartItems->count(),
            'total' => $cartTotal,
            'session_shipping' => session('cs')
        ]);
        
        return view('checkout.payment', [
            'cart_items' => $cartItems,
            'cart_total' => $cartTotal
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
        
        // Store payment data
        $paymentData = [
            'm' => $request->payment_method,
            'i' => 'SIM_' . strtoupper(substr(md5(uniqid()), 0, 6))
        ];
        
        // Store payment data in session
        session()->put('cp', $paymentData);
        session()->save();
        
        // Log for debugging
        \Log::info('Payment data stored', [
            'payment' => $paymentData,
            'cart_items' => Cart::getContent()->count(),
            'cart_total' => Cart::getTotal()
        ]);
        
        // Proceed to review
        return redirect()->route('checkout.review');
    }
    
    // Step 3: Order review
    public function review()
    {
        // Check if all information is provided
        if (!session()->has('cs') || !session()->has('cp')) {
            return redirect()->route('checkout.shipping')->with('error', 'Please complete all checkout steps.');
        }
        
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Get cart contents for display
        $cartItems = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        // Format shipping address for display
        $shipping = session('cs');
        $shipping_address = $shipping['n'] . "\n" . 
                          $shipping['a'] . "\n" . 
                          $shipping['c'] . ", " . $shipping['s'] . " " . $shipping['z'] . "\n" .
                          "Phone: " . $shipping['p'];
        
        // Log for debugging
        \Log::info('Review page cart contents', [
            'items_count' => $cartItems->count(),
            'total' => $cartTotal,
            'session_shipping' => $shipping,
            'payment_method' => session('cp.m')
        ]);
        
        return view('checkout.review', [
            'cart_items' => $cartItems,
            'cart_total' => $cartTotal,
            'shipping_address' => $shipping_address,
            'payment_method' => session('cp.m')
        ]);
    }
    
    // Process the order
    public function placeOrder()
    {
        // Verify all required information is available
        if (!session()->has('cs') || !session()->has('cp')) {
            return redirect()->route('checkout.shipping')
                ->with('error', 'Please complete all checkout steps.');
        }
        
        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
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
        $shipping = session('cs');
        $shipping_address = $shipping['n'] . "\n" . 
                          $shipping['a'] . "\n" . 
                          $shipping['c'] . ", " . $shipping['s'] . " " . $shipping['z'] . "\n" .
                          "Phone: " . $shipping['p'];

        // Get payment info from session
        $payment = session('cp');

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => Cart::getTotal(),
            'shipping_address' => $shipping_address,
            'payment_status' => 'completed',
            'payment_provider' => 'Credit Card',
            'payment_transaction_id' => $payment['i'],
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
        session()->forget(['cs', 'cp']);

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