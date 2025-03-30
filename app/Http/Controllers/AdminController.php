<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        // Fetches all users
        $users = User::all();
        
        // Fetches all products
        $products = Product::all();

        return view('admin-dashboard', compact('users', 'products')); // Pass users and products to the view
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
}
