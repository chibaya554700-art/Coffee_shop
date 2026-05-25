@extends('layouts.app')

@section('title', 'The Coffee Shop — Premium Coffee in Davao')

@section('content')

{{-- ── Hero ─────────────────────────────────────────────── --}}
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-coffee-900">

    {{-- Background image overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-coffee-900 via-coffee-800 to-coffee-600 opacity-90"></div>

    {{-- Decorative circles --}}
    <div class="absolute top-24 right-16 w-72 h-72 rounded-full bg-coffee-400/10 blur-2xl"></div>
    <div class="absolute bottom-24 left-8  w-64 h-64 rounded-full bg-coffee-200/5  blur-2xl"></div>

    <div class="relative z-10 text-center px-6 max-w-3xl mx-auto">
        <p class="text-coffee-400 uppercase tracking-[0.3em] text-sm font-light mb-4 animate-fade-up"
           style="animation-delay: 0.1s; opacity: 0; animation-fill-mode: forwards;">
            Crafted With Passion
        </p>
        <h1 class="font-serif text-5xl md:text-7xl font-bold text-cream leading-tight mb-6 animate-fade-up"
            style="animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards;">
            Every Sip, <br>A Story.
        </h1>
        <p class="text-coffee-200 text-lg font-light mb-10 leading-relaxed animate-fade-up"
           style="animation-delay: 0.5s; opacity: 0; animation-fill-mode: forwards;">
            Single-origin beans, artisan blends, and seasonal specialties — brewed to perfection, served with warmth.
        </p>
        <div class="flex flex-wrap gap-4 justify-center animate-fade-up"
             style="animation-delay: 0.7s; opacity: 0; animation-fill-mode: forwards;">
            <a href="{{ route('menu') }}"
               class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-4 rounded transition-colors">
                Explore Menu
            </a>
            <a href="#about"
               class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-8 py-4 rounded transition-colors">
                Our Story
            </a>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce text-coffee-400 opacity-60">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ── Category Pills ───────────────────────────────────── --}}
<section class="bg-coffee-50 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('menu.category', $cat->slug) }}"
                   class="flex items-center gap-2 bg-white border border-coffee-200 hover:bg-coffee-400 hover:text-cream hover:border-coffee-400 text-coffee-800 text-sm font-medium px-6 py-3 rounded-full transition-all shadow-sm">
                    <span>{{ $cat->icon }}</span>
                    <span>{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Featured Products ────────────────────────────────── --}}
<section class="py-24 bg-cream">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-3">Our Bestsellers</p>
            <h2 class="font-serif text-4xl font-bold text-coffee-900">Featured Drinks & Bites</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
                <a href="{{ route('product.show', $product->id) }}"
                   class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group block">
                    <div class="h-52 bg-gradient-to-br from-coffee-100 to-coffee-200 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <span class="text-7xl opacity-30">☕</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <span class="text-xs text-coffee-400 uppercase tracking-widest font-medium">
                            {{ $product->category->name }}
                        </span>
                        <h3 class="font-serif text-xl font-bold text-coffee-900 mt-1 mb-2">
                            {{ $product->name }}
                        </h3>
                        <p class="text-coffee-600 text-sm leading-relaxed mb-4">
                            {{ $product->description }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-coffee-800 text-lg">
                                ₱{{ number_format($product->price, 2) }}
                            </span>
                            <span class="text-sm font-bold text-coffee-400 hover:text-coffee-600 uppercase tracking-wider transition-colors">
                                Order →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('menu') }}"
               class="inline-block border-2 border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-10 py-4 rounded transition-colors">
                View Full Menu
            </a>
        </div>
    </div>
</section>

{{-- ── About / Banner ───────────────────────────────────── --}}
<section id="about" class="bg-coffee-900 py-24">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-4">Our Story</p>
            <h2 class="font-serif text-4xl font-bold text-cream mb-6 leading-snug">
                More Than Coffee. <br>It's a Community.
            </h2>
            <p class="text-coffee-200 font-light leading-relaxed mb-6">
                Since 2010, we've been sourcing the finest single-origin beans from around the world — from the highlands of Davao to the mountains of Ethiopia — and brewing them with care and craft.
            </p>
            <p class="text-coffee-200 font-light leading-relaxed">
                Our baristas are trained artisans. Our spaces are designed for connection. And every cup we serve carries a commitment to quality that never compromises.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-8">
            @foreach([['15+', 'Years of Craft'], ['3', 'Davao Locations'], ['50+', 'Drinks on Menu'], ['1000+', 'Happy Regulars']] as $stat)
                <div class="text-center p-8 border border-coffee-800 rounded-2xl">
                    <p class="font-serif text-4xl font-bold text-coffee-400 mb-2">{{ $stat[0] }}</p>
                    <p class="text-coffee-200 text-sm font-light uppercase tracking-wider">{{ $stat[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Testimonials ─────────────────────────────────────── --}}
<section class="py-24 bg-coffee-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-3">What People Say</p>
            <h2 class="font-serif text-4xl font-bold text-coffee-900">Loved by Coffee Lovers</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <div class="flex gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $testimonial->rating ? 'text-coffee-400' : 'text-coffee-100' }}">★</span>
                        @endfor
                    </div>
                    <p class="text-coffee-700 font-light leading-relaxed mb-6 italic">
                        "{{ $testimonial->message }}"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-coffee-200 flex items-center justify-center font-bold text-coffee-600">
                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                        </div>
                        <span class="font-semibold text-coffee-900 text-sm">{{ $testimonial->name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Branches / Locations ─────────────────────────────── --}}
<section id="branches" class="py-24 bg-cream">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-3">Find Us</p>
            <h2 class="font-serif text-4xl font-bold text-coffee-900">Our Locations</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($branches as $branch)
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-coffee-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-coffee-100 rounded-full flex items-center justify-center text-2xl mb-4">☕</div>
                    <h3 class="font-serif text-xl font-bold text-coffee-900 mb-1">{{ $branch->name }}</h3>
                    <p class="text-sm text-coffee-400 font-medium mb-4">{{ $branch->city }}</p>
                    <ul class="space-y-2 text-sm text-coffee-700 font-light">
                        <li>📍 {{ $branch->address }}</li>
                        @if($branch->phone)
                            <li>📞 {{ $branch->phone }}</li>
                        @endif
                        @if($branch->hours)
                            <li>🕐 {{ $branch->hours }}</li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA Banner ───────────────────────────────────────── --}}
<section class="bg-coffee-400 py-16 text-center">
    <h2 class="font-serif text-3xl font-bold text-cream mb-4">
        Ready for your next cup?
    </h2>
    <p class="text-cream/80 font-light mb-8">Browse our full menu and find your new favorite today.</p>
    <a href="{{ route('menu') }}"
       class="bg-cream text-coffee-800 hover:bg-coffee-900 hover:text-cream font-bold uppercase tracking-widest text-sm px-10 py-4 rounded transition-colors">
        See the Menu
    </a>
</section>

@endsection