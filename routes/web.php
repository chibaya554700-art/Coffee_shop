<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// --- TEMPORARY CACHE CLEAR ROUTE ---
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "All caches cleared successfully!";
});
// -----------------------------------

Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * FIX: Add dashboard route so Laravel/Breeze redirects don't go to a missing URL.
 * This prevents "Not Found" after login/register.
 */
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard')->middleware('auth');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{slug}', [MenuController::class, 'byCategory'])->name('menu.category');
Route::get('/product/{id}', [MenuController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');

Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password')->middleware('auth');

Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    // ... keep the rest of your admin routes here ...
});