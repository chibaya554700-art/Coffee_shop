<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Branch;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts   = Product::with('category')->where('is_featured', true)->take(6)->get();
        $categories         = Category::all();
        $testimonials       = Testimonial::where('is_active', true)->take(3)->get();
        $branches           = Branch::all();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'testimonials',
            'branches'
        ));
    }
}