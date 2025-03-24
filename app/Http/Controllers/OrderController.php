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

        // Add the products to the order
        foreach (Cart::getContent() as $item) {
            $order->products()->attach($item->id, [
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Clear the cart
        Cart::clear();

        // Redirect to orders index with a success message
        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
