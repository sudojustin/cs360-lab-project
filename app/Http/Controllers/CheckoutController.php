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
        
        // Store minimal shipping data with very short keys and values
        $shipping = [
            'n' => substr($request->name, 0, 100),
            'a' => substr($request->address, 0, 100),
            'c' => substr($request->city, 0, 50),
            's' => substr($request->state, 0, 20),
            'z' => substr($request->zip_code, 0, 10),
            'p' => substr($request->phone, 0, 15)
        ];
        
        session(['cs' => $shipping]);
        
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
        
        // Store minimal payment data
        session(['cp' => [
            'm' => $request->payment_method,
            'i' => 'SIM_' . strtoupper(substr(md5(uniqid()), 0, 6))
        ]]);
        
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
        
        // Format shipping address for display
        $shipping = session('cs');
        $shipping_address = $shipping['n'] . "\n" . 
                          $shipping['a'] . "\n" . 
                          $shipping['c'] . ", " . $shipping['s'] . " " . $shipping['z'] . "\n" .
                          "Phone: " . $shipping['p'];
        
        return view('checkout.review', [
            'cart_items' => Cart::getContent(),
            'cart_total' => Cart::getTotal(),
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
        
        // Verify products are in stock before creating the order
        foreach (Cart::getContent() as $item) {
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

        // Add the products to the order and reduce stock
        foreach (Cart::getContent() as $item) {
            $order->products()->attach($item->id, [
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
            
            // Reduce product stock
            $product = \App\Models\Product::find($item->id);
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