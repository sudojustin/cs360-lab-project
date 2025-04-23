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
        
        // Convert quantity to integer
        $requestedQty = (int) $request->quantity;
        
        // Ensure quantity is at least 1
        if ($requestedQty < 1) {
            $requestedQty = 1;
        }
        
        // Get current cart quantity for this product if it exists
        $cartItem = \Cart::get($request->id);
        $currentQtyInCart = $cartItem ? (int) $cartItem->quantity : 0;
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
        
        // Get cart content before adding
        $existingCartItems = \Cart::getContent();
        
        // Log the cart add for debugging
        \Log::info('Adding to cart', [
            'product_id' => $request->id,
            'product_name' => $product->name,
            'quantity' => $requestedQty,
            'current_in_cart' => $currentQtyInCart,
            'existing_items_count' => $existingCartItems->count()
        ]);
        
        // Try to remove first if it exists to prevent issues with updating
        if ($currentQtyInCart > 0) {
            \Cart::remove($request->id);
        }
        
        // Add to cart
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $totalQtyNeeded, // Use total quantity
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        
        // Log the cart after adding
        \Log::info('Cart after add', [
            'items_count' => \Cart::getContent()->count(),
            'items' => \Cart::getContent()->toArray()
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
        
        // Convert quantity to integer
        $quantity = (int) $request->quantity;
        
        // Ensure quantity is at least 1
        if ($quantity < 1) {
            $quantity = 1;
        }
        
        // Check if enough stock
        if ($product->stock < $quantity) {
            session()->flash('error', "Sorry, only {$product->stock} items available.");
            return redirect()->route('cart.list');
        }
        
        // Get existing cart item before removal
        $cartItem = \Cart::get($request->id);
        $image = null;
        
        if ($cartItem && isset($cartItem->attributes) && isset($cartItem->attributes->image)) {
            $image = $cartItem->attributes->image;
        }
        
        // Log the quantity update for debugging
        \Log::info('Updating cart quantity', [
            'product_id' => $request->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'old_quantity' => $cartItem ? $cartItem->quantity : 0,
            'has_image' => !empty($image)
        ]);
        
        // Remove then add to ensure proper update
        \Cart::remove($request->id);
        
        // Add with new quantity
        \Cart::add([
            'id' => $request->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'attributes' => array(
                'image' => $image ?? $product->image,
            )
        ]);
        
        // Log the cart after update
        \Log::info('Cart after update', [
            'items_count' => \Cart::getContent()->count(),
            'items' => \Cart::getContent()->toArray()
        ]);

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
