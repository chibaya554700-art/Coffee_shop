@extends('layouts.app')

@section('title', 'Checkout — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-2">Almost There</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">Checkout</h1>
        </div>

        <div class="grid md:grid-cols-2 gap-8">

            {{-- Order Form --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Delivery Details</h2>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                               placeholder="09XX XXX XXXX"
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Delivery Address</label>
                        <textarea name="address" rows="3" required
                                  placeholder="Street, Barangay, City"
                                  class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors resize-none">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-coffee-800 mb-3">Payment Method</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="cash" checked class="accent-coffee-400">
                                <span class="text-sm text-coffee-700">💵 Cash</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="gcash" class="accent-coffee-400">
                                <span class="text-sm text-coffee-700">📱 GCash</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="accent-coffee-400">
                                <span class="text-sm text-coffee-700">💳 Card</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-4 rounded-lg transition-colors">
                        Place Order
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-2xl shadow-sm p-8 sticky top-32">
                    <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Order Summary</h2>

                    <div class="space-y-4 mb-6">
                        @foreach($cart as $id => $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-coffee-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                 alt="{{ $item['name'] }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span>☕</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-coffee-900">{{ $item['name'] }}</p>
                                        <p class="text-xs text-coffee-400">x{{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <span class="font-bold text-coffee-900 text-sm">
                                    ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-coffee-100 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-serif text-lg font-bold text-coffee-900">Total</span>
                            <span class="font-serif text-2xl font-bold text-coffee-400">
                                ₱{{ number_format($total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection