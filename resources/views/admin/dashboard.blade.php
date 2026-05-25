@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-10 flex items-center justify-between">
            <div>
                <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
                <h1 class="font-serif text-4xl font-bold text-coffee-900">Dashboard</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.products') }}"
                   class="bg-coffee-400 hover:bg-coffee-600 text-cream text-sm font-bold uppercase tracking-widest px-5 py-2.5 rounded transition-colors">
                    Manage Products
                </a>
                <a href="{{ route('admin.categories') }}"
                   class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream text-sm font-bold uppercase tracking-widest px-5 py-2.5 rounded transition-colors">
                    Manage Categories
                </a>
                <a href="{{ route('admin.orders') }}"
                   class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream text-sm font-bold uppercase tracking-widest px-5 py-2.5 rounded transition-colors">
                    View Orders
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <p class="text-3xl font-serif font-bold text-coffee-400">{{ $totalProducts }}</p>
                <p class="text-sm text-coffee-600 mt-1 uppercase tracking-wider">Products</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <p class="text-3xl font-serif font-bold text-coffee-400">{{ $totalOrders }}</p>
                <p class="text-sm text-coffee-600 mt-1 uppercase tracking-wider">Orders</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <p class="text-3xl font-serif font-bold text-coffee-400">{{ $totalUsers }}</p>
                <p class="text-sm text-coffee-600 mt-1 uppercase tracking-wider">Users</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <p class="text-3xl font-serif font-bold text-coffee-400">₱{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-sm text-coffee-600 mt-1 uppercase tracking-wider">Revenue</p>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-coffee-100">
                <h2 class="font-serif text-xl font-bold text-coffee-900">Recent Orders</h2>
            </div>
            <table class="w-full">
                <thead class="bg-coffee-50">
                    <tr>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-3">Order #</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-3">Customer</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-3">Total</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-3">Status</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50">
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 font-bold text-coffee-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-coffee-700">{{ $order->name }}</td>
                            <td class="px-6 py-4 font-bold text-coffee-900">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $order->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $order->status === 'preparing' ? 'bg-blue-100 text-blue-700'    : '' }}
                                    {{ $order->status === 'ready'     ? 'bg-green-100 text-green-700'  : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-coffee-100 text-coffee-700': '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700'      : '' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-coffee-600 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection