@extends('layouts.app')

@section('title', 'Order Placed — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-2xl mx-auto px-6 text-center">

        <div class="bg-white rounded-2xl shadow-sm p-12">
            <div class="text-6xl mb-4">🎉</div>
            <h1 class="font-serif text-4xl font-bold text-coffee-900 mb-2">Order Placed!</h1>
            <p class="text-coffee-600 font-light mb-8">
                Thank you, {{ $order->name }}! Your order has been received and is being prepared.
            </p>

            {{-- Order Details --}}
            <div class="bg-coffee-50 rounded-xl p-6 text-left mb-8">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-coffee-600">Order #</span>
                    <span class="font-bold text-coffee-900">{{ $order->id }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-coffee-600">Payment</span>
                    <span class="font-bold text-coffee-900 capitalize">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-sm text-coffee-600">Status</span>
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full uppercase">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="border-t border-coffee-200 pt-4 space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-coffee-700">{{ $item->product_name }} x{{ $item->quantity }}</span>
                            <span class="font-medium text-coffee-900">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-coffee-200 pt-4 mt-4 flex justify-between">
                    <span class="font-bold text-coffee-900">Total</span>
                    <span class="font-serif text-xl font-bold text-coffee-400">₱{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <a href="{{ route('home') }}"
                   class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                    Go Home
                </a>
                <a href="{{ route('menu') }}"
                   class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                    Order More
                </a>
            </div>
        </div>
    </div>
</section>

@endsection