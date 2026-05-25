<nav class="fixed top-0 w-full z-50 bg-coffee-900/95 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="text-2xl">☕</span>
            <span class="font-serif text-xl font-bold text-cream tracking-wide">
                The Coffee Shop
            </span>
        </a>

        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-6 text-sm font-light tracking-widest uppercase text-coffee-200">
            <li>
                <a href="{{ route('home') }}"
                   class="hover:text-coffee-400 transition-colors {{ request()->routeIs('home') ? 'text-coffee-400' : '' }}">
                   Home
                </a>
            </li>
            <li>
                <a href="{{ route('menu') }}"
                   class="hover:text-coffee-400 transition-colors {{ request()->routeIs('menu*') ? 'text-coffee-400' : '' }}">
                   Menu
                </a>
            </li>
            <li><a href="#branches" class="hover:text-coffee-400 transition-colors">Locations</a></li>
            <li><a href="#about"    class="hover:text-coffee-400 transition-colors">About</a></li>
        </ul>

        {{-- Desktop Right Side --}}
        <div class="hidden md:flex items-center gap-3">

            {{-- Cart Icon --}}
            @php $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity')); @endphp
            <a href="{{ route('cart') }}" class="relative text-coffee-200 hover:text-coffee-400 transition-colors text-xl">
                🛒
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-coffee-400 text-cream text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            @guest
                <a href="{{ route('login') }}"
                   class="text-coffee-200 hover:text-coffee-400 text-sm uppercase tracking-widest transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="text-coffee-200 hover:text-coffee-400 text-sm uppercase tracking-widest transition-colors">
                    Register
                </a>
            @else
                {{-- User Dropdown --}}
                <div class="relative group">
                    <button class="text-coffee-200 hover:text-coffee-400 text-sm uppercase tracking-widest transition-colors flex items-center gap-1">
                        Hi, {{ explode(' ', Auth::user()->name)[0] }}!
                        <span class="text-xs">▾</span>
                    </button>
                    <div class="absolute right-0 top-full w-48 pt-2 hidden group-hover:block z-50">
                        <div class="bg-white rounded-xl shadow-lg py-2">
                            <a href="{{ route('profile') }}"
                               class="block px-4 py-2 text-sm text-coffee-700 hover:bg-coffee-50">
                                👤 My Profile
                            </a>
                            <a href="{{ route('orders.index') }}"
                               class="block px-4 py-2 text-sm text-coffee-700 hover:bg-coffee-50">
                                📋 My Orders
                            </a>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}"
                                   class="block px-4 py-2 text-sm text-coffee-700 hover:bg-coffee-50 font-bold">
                                    ⚙️ Admin Panel
                                </a>
                            @endif
                            <div class="border-t border-coffee-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endguest

            <a href="{{ route('menu') }}"
               class="bg-coffee-400 hover:bg-coffee-600 text-cream text-sm font-bold uppercase tracking-widest px-5 py-2.5 rounded transition-colors">
                Order Now
            </a>
        </div>

        {{-- Mobile Menu Button --}}
        <button id="menu-btn" class="md:hidden text-cream focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobile-menu" class="hidden md:hidden bg-coffee-900 px-6 pb-4">
        <ul class="flex flex-col gap-4 text-sm text-coffee-200 uppercase tracking-widest">
            <li><a href="{{ route('home') }}" class="block py-1 hover:text-coffee-400">Home</a></li>
            <li><a href="{{ route('menu') }}" class="block py-1 hover:text-coffee-400">Menu</a></li>
            <li><a href="#branches"           class="block py-1 hover:text-coffee-400">Locations</a></li>
            <li><a href="#about"              class="block py-1 hover:text-coffee-400">About</a></li>

            {{-- Mobile Cart --}}
            <li>
                <a href="{{ route('cart') }}" class="flex items-center gap-2 py-1 hover:text-coffee-400">
                    <span>🛒</span>
                    <span>Cart</span>
                    @if($cartCount > 0)
                        <span class="bg-coffee-400 text-cream text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </li>

            @guest
                <li><a href="{{ route('login') }}"    class="block py-1 hover:text-coffee-400">Login</a></li>
                <li><a href="{{ route('register') }}" class="block py-1 hover:text-coffee-400">Register</a></li>
            @else
                <li>
                    <a href="{{ route('profile') }}" class="block py-1 hover:text-coffee-400">
                        👤 My Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="block py-1 hover:text-coffee-400">
                        📋 My Orders
                    </a>
                </li>
                @if(Auth::user()->is_admin)
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="block py-1 text-coffee-400 font-bold hover:text-coffee-200">
                            ⚙️ Admin Panel
                        </a>
                    </li>
                @endif
                <li class="text-coffee-400 text-xs py-1">
                    Hi, {{ explode(' ', Auth::user()->name)[0] }}!
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block py-1 hover:text-coffee-400 uppercase tracking-widest">
                            Logout
                        </button>
                    </form>
                </li>
            @endguest

            <li>
                <a href="{{ route('menu') }}"
                   class="inline-block bg-coffee-400 text-cream px-4 py-2 rounded text-xs font-bold mt-2">
                    Order Now
                </a>
            </li>
        </ul>
    </div>
</nav>

@push('scripts')
<script>
    const btn  = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>
@endpush