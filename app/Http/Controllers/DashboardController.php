<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Define the index method to handle the dashboard view
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Pass the products to the view
        return view('dashboard', compact('products'));
    }
}
