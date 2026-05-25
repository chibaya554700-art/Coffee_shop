@extends('layouts.app')

@section('title', 'My Profile — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-3xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-2">Account</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">My Profile</h1>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-8">

            {{-- Update Profile --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Personal Info</h2>

                @if($errors->has('name') || $errors->has('email'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors">
                    </div>

                    <button type="submit"
                            class="w-full bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-3.5 rounded-lg transition-colors">
                        Update Profile
                    </button>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Change Password</h2>

                @if($errors->has('current_password') || $errors->has('password'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Current Password</label>
                        <input type="password" name="current_password" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                               placeholder="••••••••">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">New Password</label>
                        <input type="password" name="password" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                               placeholder="••••••••">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                               placeholder="••••••••">
                    </div>

                    <button type="submit"
                            class="w-full bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-3.5 rounded-lg transition-colors">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="mt-8 flex gap-4 justify-center">
            <a href="{{ route('orders.index') }}"
               class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                My Orders
            </a>
            <a href="{{ route('menu') }}"
               class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                Browse Menu
            </a>
        </div>
    </div>
</section>

@endsection