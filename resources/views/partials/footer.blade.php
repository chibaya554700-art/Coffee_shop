<footer class="bg-coffee-900 text-coffee-200 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 mb-12">

        {{-- Brand --}}
        <div>
            <div class="flex items-center gap-2 mb-4">
                <span class="text-2xl">☕</span>
                <span class="font-serif text-xl font-bold text-cream">The Coffee Shop</span>
            </div>
            <p class="text-sm font-light leading-relaxed opacity-80">
                Crafting exceptional coffee experiences since 2010. Every cup tells a story of origin, craft, and passion.
            </p>
        </div>

        {{-- Quick Links --}}
        <div>
            <h4 class="font-serif text-lg text-cream mb-4">Quick Links</h4>
            <ul class="space-y-2 text-sm font-light opacity-80">
                <li><a href="{{ route('home') }}"  class="hover:text-coffee-400 transition-colors">Home</a></li>
                <li><a href="{{ route('menu') }}"  class="hover:text-coffee-400 transition-colors">Menu</a></li>
                <li><a href="#branches"            class="hover:text-coffee-400 transition-colors">Find a Store</a></li>
                <li><a href="#about"               class="hover:text-coffee-400 transition-colors">About Us</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h4 class="font-serif text-lg text-cream mb-4">Get in Touch</h4>
            <ul class="space-y-2 text-sm font-light opacity-80">
                <li>📍 Davao City, Philippines</li>
                <li>📞 (082) 123-4567</li>
                <li>✉️ hello@thecoffeeshop.ph</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-coffee-800 pt-6 text-center text-xs opacity-50">
        &copy; {{ date('Y') }} The Coffee Shop. All rights reserved.
    </div>
</footer>