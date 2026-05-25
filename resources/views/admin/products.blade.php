@extends('layouts.app')

@section('title', 'Manage Products — Admin')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
                <h1 class="font-serif text-4xl font-bold text-coffee-900">Products</h1>
            </div>
            <a href="{{ route('admin.products.create') }}"
               class="bg-coffee-400 hover:bg-coffee-600 text-cream text-sm font-bold uppercase tracking-widest px-5 py-2.5 rounded transition-colors">
                + Add Product
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-coffee-50 border-b border-coffee-100">
                    <tr>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Product</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Category</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Price</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Featured</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Available</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-coffee-100 overflow-hidden flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-lg">☕</div>
                                        @endif
                                    </div>
                                    <span class="font-medium text-coffee-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-coffee-600">{{ $product->category->name }}</td>
                            <td class="px-6 py-4 font-bold text-coffee-900">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $product->is_featured ? 'text-green-600' : 'text-coffee-300' }}">
                                    {{ $product->is_featured ? '✓ Yes' : '✗ No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $product->is_available ? 'text-green-600' : 'text-red-400' }}">
                                    {{ $product->is_available ? '✓ Yes' : '✗ No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="text-xs text-coffee-400 hover:text-coffee-600 font-medium uppercase tracking-wider">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product) }}" method="POST"
                                          onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-400 hover:text-red-600 font-medium uppercase tracking-wider">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-coffee-400 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</section>
@endsection