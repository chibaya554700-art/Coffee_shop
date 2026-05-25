@extends('layouts.app')

@section('title', 'My Orders — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-2">Your History</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">My Orders</h1>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
                <span class="text-7xl">📋</span>
                <h2 class="font-serif text-2xl font-bold text-coffee-900 mt-4 mb-2">No orders yet</h2>
                <p class="text-coffee-600 font-light mb-6">You haven't placed any orders yet.</p>
                <a href="{{ route('menu') }}"
                   class="inline-block bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                    Browse Menu
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm p-6">

                        {{-- Order Header --}}
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-coffee-900">
                                    Order #{{ $order->id }}
                                </h3>
                                <p class="text-xs text-coffee-400 mt-1">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-serif text-2xl font-bold text-coffee-400">
                                    ₱{{ number_format($order->total, 2) }}
                                </p>
                                <p class="text-xs text-coffee-600 capitalize">{{ $order->payment_method }}</p>
                            </div>
                        </div>

                        {{-- Status Tracker --}}
                        @php
                            $steps = ['pending', 'preparing', 'ready', 'delivered'];
                            $currentStep = array_search($order->status, $steps);
                            $isCancelled = $order->status === 'cancelled';
                        @endphp

                        @if($isCancelled)
                            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6 text-center">
                                <span class="text-red-500 font-bold text-sm uppercase tracking-wider">❌ Order Cancelled</span>
                            </div>
                        @else
                            <div class="mb-6">
                                <div class="flex items-center justify-between relative">

                                    {{-- Progress Line --}}
                                    <div class="absolute top-5 left-0 right-0 h-1 bg-coffee-100 z-0">
                                        <div class="h-full bg-coffee-400 transition-all duration-500"
                                             style="width: {{ $currentStep === false ? 0 : ($currentStep / (count($steps) - 1)) * 100 }}%">
                                        </div>
                                    </div>

                                    @foreach($steps as $index => $step)
                                        @php
                                            $isCompleted = $currentStep !== false && $index <= $currentStep;
                                            $isActive    = $currentStep !== false && $index === $currentStep;
                                        @endphp
                                        <div class="flex flex-col items-center z-10 flex-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition-all
                                                {{ $isCompleted ? 'bg-coffee-400 text-cream' : 'bg-coffee-100 text-coffee-400' }}
                                                {{ $isActive ? 'ring-4 ring-coffee-200' : '' }}">
                                                @if($isCompleted && $index < $currentStep)
                                                    ✓
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </div>
                                            <span class="text-xs uppercase tracking-wider font-medium
                                                {{ $isCompleted ? 'text-coffee-600' : 'text-coffee-300' }}">
                                                {{ ucfirst($step) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Order Items --}}
                        <div class="border-t border-coffee-50 pt-4 mb-4 space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-coffee-700">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                    <span class="font-medium text-coffee-900">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm text-coffee-600">
                                📍 {{ $order->address }}
                            </div>
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="text-xs text-coffee-400 hover:text-coffee-600 font-medium uppercase tracking-wider transition-colors">
                                View Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection