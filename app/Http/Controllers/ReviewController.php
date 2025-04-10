<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:1'
        ]);

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Review submitted successfully!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:1'
        ]);

        $review->update($request->only(['rating', 'comment']));

        return redirect()->route('products.show', $review->product)->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = $review->product;
        $review->delete();

        return redirect()->route('products.show', $product)->with('success', 'Review deleted successfully!');
    }
} 