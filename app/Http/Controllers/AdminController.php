<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalUsers    = User::count();
        $totalRevenue  = Order::where('status', '!=', 'cancelled')->sum('total');
        $recentOrders  = Order::with('items')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders'
        ));
    }

    // Products
    public function products()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.product-form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_featured']  = $request->has('is_featured');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // storage/app/public/products/...
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path; // "products/filename.jpg"
        }

        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.product-form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_featured']  = $request->has('is_featured');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (!empty($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        if (!empty($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted!');
    }

    // Orders
    public function orders()
    {
        $orders = Order::with('items')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated!');
    }

    // Categories
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.category-form');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'icon' => 'nullable|string|max:10',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.category-form', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:10',
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted!');
    }

    // Users
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'User role updated!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }
        $user->delete();
        return back()->with('success', 'User deleted!');
    }
}