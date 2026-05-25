@extends('layouts.app')

@section('title', 'Manage Orders — Admin')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-8">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">Orders</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-coffee-900">Order #{{ $order->id }}</h3>
                            <p class="text-sm text-coffee-600">{{ $order->name }} — {{ $order->phone }}</p>
                            <p class="text-sm text-coffee-600">{{ $order->address }}</p>
                            <p class="text-xs text-coffee-400 mt-1">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-serif text-2xl font-bold text-coffee-400">₱{{ number_format($order->total, 2) }}</p>
                            <p class="text-xs text-coffee-600 uppercase tracking-wider">{{ $order->payment_method }}</p>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="border-t border-coffee-50 pt-4 mb-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between text-sm py-1">
                                <span class="text-coffee-700">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                <span class="font-medium text-coffee-900">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status Update --}}
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST"
                          class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                                class="border border-coffee-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-coffee-400">
                            @foreach(['pending', 'preparing', 'ready', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="bg-coffee-400 hover:bg-coffee-600 text-cream text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-lg transition-colors">
                            Update
                        </button>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                            {{ $order->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $order->status === 'preparing' ? 'bg-blue-100 text-blue-700'    : '' }}
                            {{ $order->status === 'ready'     ? 'bg-green-100 text-green-700'  : '' }}
                            {{ $order->status === 'delivered' ? 'bg-coffee-100 text-coffee-700': '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700'      : '' }}">
                            {{ $order->status }}
                        </span>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-coffee-400 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</section>
@endsection