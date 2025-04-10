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

    public function showProducts(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Price range filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        // In stock filter
        if ($request->has('in_stock') && $request->in_stock == '1') {
            $query->where('stock', '>', 0);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting by newest
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        
        return view('products', compact('products'));
    }

    public function show(Product $product)
    {
        return view('product-detail', compact('product'));
    }
}
