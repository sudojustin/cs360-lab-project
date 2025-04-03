<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*public function productList()*/
    /*{*/
    /*    $products = Product::all();*/
    /**/
    /*    return view('dashboard', compact('products'));*/
    /*}*/

    public function showDashboard()
    {
        $products = Product::all();
        $randomProducts = Product::inRandomOrder()->limit(8)->get();
        return view('dashboard', compact('products', 'randomProducts')); // Pass products to the dashboard view
    }

    public function showProducts()
    {
        $products = Product::all();
        return view('products', compact('products')); // Pass products to the products view
    }
}
