<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        try {
            // Get cart items
            $cartItems = \Cart::getContent();
            
            // Log cart contents for debugging
            \Log::info('Cart list accessed', [
                'cart_count' => $cartItems->count(),
                'cart_items' => $cartItems->toArray(),
                'cart_total' => \Cart::getTotal()
            ]);
            
            // If we somehow have no cart items but should, try to recover
            if ($cartItems->isEmpty() && session()->has('last_known_cart')) {
                \Log::warning('Attempting to recover cart from session', [
                    'last_known_cart' => session('last_known_cart')
                ]);
                
                // We could implement recovery here if needed
            }
            
            // Store current cart in session for potential recovery
            if (!$cartItems->isEmpty()) {
                session(['last_known_cart' => $cartItems->toArray()]);
            }
            
            return view('cart', compact('cartItems'));
        } catch (\Exception $e) {
            \Log::error('Exception in cart list', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Handle error gracefully
            $cartItems = collect([]);
            return view('cart', compact('cartItems'))->with('error', 'There was an issue loading your cart. Please try again.');
        }
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
        
        try {
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
            
            // Get all cart items before adding - for debugging
            $cartItems = \Cart::getContent()->toArray();
            
            // Log the cart before adding
            \Log::info('Cart before adding item', [
                'cart_count' => count($cartItems),
                'cart_items' => $cartItems,
                'adding_product' => [
                    'id' => $request->id,
                    'name' => $request->name,
                    'quantity' => $requestedQty
                ]
            ]);
            
            // Try to add to cart - with error handling
            \Cart::add([
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $requestedQty,
                'attributes' => array(
                    'image' => $request->image,
                )
            ]);
            
            // Get cart items after adding - for debugging
            $updatedCart = \Cart::getContent()->toArray();
            
            // Log the cart after adding
            \Log::info('Cart after adding item', [
                'cart_count' => count($updatedCart),
                'cart_items' => $updatedCart
            ]);
            
            // Verify the item was added successfully
            if (!isset($updatedCart[$request->id])) {
                \Log::error('Failed to add item to cart', [
                    'product_id' => $request->id,
                    'product_name' => $request->name
                ]);
                session()->flash('error', 'There was an issue adding the product to your cart. Please try again.');
            } else {
                session()->flash('success', 'Product is Added to Cart Successfully!');
            }
            
            return redirect()->route('cart.list');
        } catch (\Exception $e) {
            \Log::error('Exception adding to cart', [
                'product_id' => $request->id,
                'product_name' => $product->name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'There was an error adding the product to your cart. Please try again.');
            return redirect()->back();
        }
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
        
        // Log the quantity update for debugging
        \Log::info('Updating cart quantity', [
            'product_id' => $request->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'old_quantity' => \Cart::get($request->id) ? \Cart::get($request->id)->quantity : 0
        ]);
        
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $quantity
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
