<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        // Get the product to check stock
        $product = \App\Models\Product::find($request->id);
        
        // Check if product exists and has enough stock
        if (!$product) {
            session()->flash('error', 'Product not found!');
            return redirect()->back();
        }
        
        // Get current cart quantity for this product if it exists
        $cartItem = \Cart::get($request->id);
        $currentQtyInCart = $cartItem ? $cartItem->quantity : 0;
        $requestedQty = $request->quantity;
        $totalQtyNeeded = $currentQtyInCart + $requestedQty;
        
        // Check if enough stock
        if ($product->stock < $totalQtyNeeded) {
            if ($product->stock <= 0) {
                session()->flash('error', 'This product is out of stock!');
            } else if ($currentQtyInCart > 0) {
                session()->flash('error', "Only {$product->stock} items available. You already have {$currentQtyInCart} in your cart.");
            } else {
                session()->flash('error', "Only {$product->stock} items available.");
            }
            return redirect()->back();
        }
        
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully!');

        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        // Get the product to check stock
        $product = \App\Models\Product::find($request->id);
        
        // Check if product exists and has enough stock
        if (!$product) {
            session()->flash('error', 'Product not found!');
            return redirect()->route('cart.list');
        }
        
        // Check if enough stock
        if ($product->stock < $request->quantity) {
            session()->flash('error', "Sorry, only {$product->stock} items available.");
            return redirect()->route('cart.list');
        }
        
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Cart updated successfully!');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }
}
