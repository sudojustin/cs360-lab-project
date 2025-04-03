<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders; // Assuming you have a relationship defined in User model
        return view('orders', compact('orders'));
    }

    // Store order method
    public function store(Request $request)
    {
        $user = auth()->user();  // Get the authenticated user

        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.list')->with('error', 'Your cart is empty. Please add items before checking out.');
        }
        
        // Verify products are in stock before creating the order
        foreach (Cart::getContent() as $item) {
            $product = \App\Models\Product::find($item->id);
            
            if (!$product || $product->stock < $item->quantity) {
                return redirect()->route('cart.list')->with('error', 'Some items in your cart are no longer available in the requested quantity. Please update your cart.');
            }
        }

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => Cart::getTotal(),
            'shipping_address' => $request->shipping_address,
            'payment_status' => 'unpaid',
            'payment_provider' => $request->payment_provider,
            'payment_transaction_id' => $request->payment_transaction_id,
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

        // Clear the cart
        Cart::clear();

        // Redirect to orders index with a success message
        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
