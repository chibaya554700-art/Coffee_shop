@extends('layouts.app')

@section('title', 'Order #{{ $order->id }} — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-2xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-2">Order Details</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">Order #{{ $order->id }}</h1>
            <p class="text-coffee-600 text-sm mt-2">{{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">

            {{-- Status --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-serif text-xl font-bold text-coffee-900">Status</h2>
                <span class="px-4 py-1.5 rounded-full text-sm font-bold uppercase
                    {{ $order->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $order->status === 'preparing' ? 'bg-blue-100 text-blue-700'    : '' }}
                    {{ $order->status === 'ready'     ? 'bg-green-100 text-green-700'  : '' }}
                    {{ $order->status === 'delivered' ? 'bg-coffee-100 text-coffee-700': '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700'      : '' }}">
                    {{ $order->status }}
                </span>
            </div>

            {{-- Delivery Info --}}
            <div class="border-t border-coffee-50 pt-6 mb-6">
                <h2 class="font-serif text-lg font-bold text-coffee-900 mb-4">Delivery Info</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-coffee-600">Name</span>
                        <span class="font-medium text-coffee-900">{{ $order->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-coffee-600">Email</span>
                        <span class="font-medium text-coffee-900">{{ $order->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-coffee-600">Phone</span>
                        <span class="font-medium text-coffee-900">{{ $order->phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-coffee-600">Address</span>
                        <span class="font-medium text-coffee-900">{{ $order->address }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-coffee-600">Payment</span>
                        <span class="font-medium text-coffee-900 capitalize">{{ $order->payment_method }}</span>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="border-t border-coffee-50 pt-6 mb-6">
                <h2 class="font-serif text-lg font-bold text-coffee-900 mb-4">Items Ordered</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-coffee-700">{{ $item->product_name }} x{{ $item->quantity }}</span>
                            <span class="font-bold text-coffee-900">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="border-t border-coffee-100 pt-4 flex justify-between items-center">
                <span class="font-serif text-lg font-bold text-coffee-900">Total</span>
                <span class="font-serif text-3xl font-bold text-coffee-400">
                    ₱{{ number_format($order->total, 2) }}
                </span>
            </div>
        </div>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('orders.index') }}"
               class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                ← My Orders
            </a>
            <a href="{{ route('menu') }}"
               class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                Order Again
            </a>
        </div>
    </div>
</section>

@endsection