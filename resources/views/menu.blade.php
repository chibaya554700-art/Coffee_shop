@extends('layouts.app')

@section('title', 'Menu — The Coffee Shop')

@section('content')

{{-- Header --}}
<div class="bg-coffee-900 pt-32 pb-6 text-center">
    <p class="text-coffee-400 uppercase tracking-widest text-xs mb-3">What We Brew</p>
    <h1 class="font-serif text-5xl font-bold text-cream mb-6">Our Menu</h1>

    {{-- Search Bar --}}
    <div class="max-w-2xl mx-auto px-6 pb-6">
        <form action="{{ route('menu') }}" method="GET">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Search drinks, food..."
                       class="w-full rounded-lg px-5 py-3 text-sm text-coffee-900 focus:outline-none focus:ring-2 focus:ring-coffee-400">
                <button type="submit"
                        class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                    Search
                </button>
            </div>
            {{-- Show search result message --}}
            @if(isset($search) && $search)
               <p class="text-cream text-xs mt-3">
                    Showing results for <span class="font-bold text-cream">"{{ $search }}"</span>
                    <a href="{{ route('menu') }}" class="underline text-coffee-400 hover:text-cream">Clear</a>
                </p>
            @endif
        </form>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm text-center px-4 py-3">
        {{ session('success') }}
    </div>
@endif

{{-- Category Filter --}}
<div class="bg-coffee-50 sticky top-[72px] z-40 border-b border-coffee-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap gap-3">
        <a href="{{ route('menu') }}"
           class="px-5 py-2 rounded-full text-sm font-medium transition-colors
                  {{ !isset($category) ? 'bg-coffee-400 text-cream' : 'bg-white text-coffee-700 hover:bg-coffee-100 border border-coffee-200' }}">
            All
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('menu.category', $cat->slug) }}"
               class="px-5 py-2 rounded-full text-sm font-medium transition-colors flex items-center gap-1.5
                      {{ isset($category) && $category->id === $cat->id
                            ? 'bg-coffee-400 text-cream'
                            : 'bg-white text-coffee-700 hover:bg-coffee-100 border border-coffee-200' }}">
                <span>{{ $cat->icon }}</span>
                <span>{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>
</div>

{{-- Products Grid --}}
<section class="py-16 bg-cream">
    <div class="max-w-7xl mx-auto px-6">

        @if($products->isEmpty())
            <div class="text-center py-20 text-coffee-400">
                <p class="text-5xl mb-4">🔍</p>
                <p class="font-serif text-2xl">No items found for "{{ $search }}".</p>
                <a href="{{ route('menu') }}"
                   class="inline-block mt-6 bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                    View All Products
                </a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group cursor-pointer">
                        <a href="{{ route('product.show', $product->id) }}">
                        <div class="h-44 bg-gradient-to-br from-coffee-100 to-coffee-200 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="text-6xl opacity-30">
                                    {{ $product->category->icon ?? '☕' }}
                                </span>
                            @endif
                        </div>
                        <div class="p-5">
                            <span class="text-xs text-coffee-400 uppercase tracking-widest font-medium">
                                {{ $product->category->name }}
                            </span>
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h3 class="font-serif text-lg font-bold text-coffee-900 mt-0.5 mb-1 hover:text-coffee-400 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                            @if($product->description)
                                <p class="text-coffee-600 text-xs leading-relaxed mb-3 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between mt-auto">
                                <span class="font-bold text-coffee-800">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                                @if(!$product->is_available)
                                    <span class="text-xs text-red-400 font-medium">Unavailable</span>
                                @else
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs bg-coffee-400 hover:bg-coffee-600 text-cream px-3 py-1.5 rounded-full font-bold uppercase tracking-wide transition-colors">
                                            Add
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection