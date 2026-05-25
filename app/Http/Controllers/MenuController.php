<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $search     = $request->input('search');

        $products = Product::with('category')
                    ->when($search, function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                    })
                    ->get();

        return view('menu', compact('categories', 'products', 'search'));
    }

    public function byCategory($slug)
    {
        $category   = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $search     = request('search');

        $products = Product::with('category')
                    ->where('category_id', $category->id)
                    ->when($search, function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->get();

        return view('menu', compact('categories', 'products', 'category', 'search'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->take(4)
                    ->get();

        return view('product', compact('product', 'related'));
    }
}