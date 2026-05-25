<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        $cart  = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Create order
        $order = Order::create([
            'user_id'        => Auth::id(),
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'payment_method' => $request->payment_method,
            'total'          => $total,
            'status'         => 'pending',
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.success', $order->id);
    }

    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('order-success', compact('order'));
    }
}