@extends('layouts.app')

@section('title', 'Your Cart — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-2">Your Order</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">Your Cart</h1>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($cart))
            {{-- Empty Cart --}}
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
                <span class="text-7xl">🛒</span>
                <h2 class="font-serif text-2xl font-bold text-coffee-900 mt-4 mb-2">Your cart is empty</h2>
                <p class="text-coffee-600 font-light mb-6">Add some delicious items from our menu!</p>
                <a href="{{ route('menu') }}"
                   class="inline-block bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                    Browse Menu
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
                <table class="w-full">
                    <thead class="bg-coffee-50 border-b border-coffee-100">
                        <tr>
                            <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Item</th>
                            <th class="text-center text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Qty</th>
                            <th class="text-right text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Price</th>
                            <th class="text-right text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-50">
                        @foreach($cart as $id => $item)
                            <tr>
                                {{-- Item Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-coffee-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                     alt="{{ $item['name'] }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl">☕</span>
                                            @endif
                                        </div>
                                        <span class="font-serif font-bold text-coffee-900">{{ $item['name'] }}</span>
                                    </div>
                                </td>

                                {{-- Quantity --}}
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                                class="w-7 h-7 rounded-full bg-coffee-100 hover:bg-coffee-200 text-coffee-800 font-bold text-sm transition-colors">
                                            −
                                        </button>
                                        <span class="w-6 text-center font-medium text-coffee-900">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                class="w-7 h-7 rounded-full bg-coffee-100 hover:bg-coffee-200 text-coffee-800 font-bold text-sm transition-colors">
                                            +
                                        </button>
                                    </form>
                                </td>

                                {{-- Price --}}
                                <td class="px-6 py-4 text-right font-bold text-coffee-900">
                                    ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </td>

                                {{-- Remove --}}
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-400 hover:text-red-600 text-xs uppercase tracking-wider font-medium transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="text-sm text-coffee-400 hover:text-coffee-600 uppercase tracking-wider font-medium transition-colors">
                        Clear Cart
                    </button>
                </form>

                <div class="text-right">
                    <p class="text-sm text-coffee-600 font-light mb-1">Total</p>
                    <p class="font-serif text-3xl font-bold text-coffee-900">₱{{ number_format($total, 2) }}</p>
                </div>

                <a href="{{ route('menu') }}"
                   class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                    Add More
                </a>

                {{-- FIXED: Changed from button to link --}}
                <a href="{{ route('checkout') }}"
                   class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                    Checkout
                </a>
            </div>
        @endif
    </div>
</section>

@endsection