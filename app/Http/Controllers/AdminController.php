<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        // Fetches all users
        $users = User::all();
        
        // Fetches all products
        $products = Product::all();
        
        // Fetches all orders with user relationship
        $orders = Order::with('user')->latest()->get();

        return view('admin-dashboard', compact('users', 'products', 'orders')); // Pass users, products, and orders to the view
    }
    
    public function deleteUser(User $user)
    {
        // Don't allow deletion of the currently authenticated user
        if (auth()->id() === $user->id) {
            return redirect()->route('admin')->with('error', 'You cannot delete yourself.');
        }
        
        // Don't allow deletion of an admin user (extra protection)
        if ($user->is_admin) {
            return redirect()->route('admin')->with('error', 'Admin users cannot be deleted.');
        }
        
        // Delete the user
        $user->delete();
        
        return redirect()->route('admin')->with('success', 'User deleted successfully.');
    }
    
    public function deleteProduct(Product $product)
    {
        // Delete the product
        $product->delete();
        
        return redirect()->route('admin')->with('success', 'Product deleted successfully.');
    }
    
    public function createProductForm()
    {
        return view('create-product');
    }
    
    public function storeProduct(Request $request)
    {
        // Basic validation for product data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image_type' => 'required|in:file,url',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048', // Max 2MB
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
        ]);
        
        // Initialize image url variable
        $imageUrl = null;
        
        // Process image based on type
        if ($request->image_type === 'url' && !empty($request->image_url)) {
            $imageUrl = $request->image_url;
        } elseif ($request->image_type === 'file' && $request->hasFile('image_file')) {
            // Store the uploaded file
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = asset('storage/' . $path);
        }
        
        // Set default image if none provided
        if (empty($imageUrl)) {
            $imageUrl = 'https://placehold.co/600x400?text=No+Image+Available';
        }
        
        // Create the new product
        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $imageUrl,
            'category' => $validated['category'],
            'stock' => $validated['stock'],
        ]);
        
        return redirect()->route('admin')->with('success', 'Product created successfully.');
    }

    public function showOrder(Order $order)
    {
        // Load the order with its related products and user
        $order->load(['products', 'user']);
        
        return view('admin-order-details', compact('order'));
    }
    
    public function updateOrder(Request $request, Order $order)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        // Update the order status
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
    
    public function updateStock(Request $request, Product $product)
    {
        // Validate the request
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);
        
        // Update the product stock
        $product->stock = $request->stock;
        $product->save();
        
        return redirect()->route('admin')->with('success', 'Product stock updated successfully.');
    }
}
