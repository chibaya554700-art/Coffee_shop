<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if user already reviewed this product
        $existing = Review::where('user_id', Auth::id())
                          ->where('product_id', $productId)
                          ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product!');
        }

        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        $review->delete();

        return back()->with('success', 'Review deleted!');
    }
}