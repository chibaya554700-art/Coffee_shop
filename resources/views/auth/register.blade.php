@extends('layouts.app')

@section('title', 'Register — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream flex items-center justify-center pt-24 pb-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm p-10">

            {{-- Header --}}
            <div class="text-center mb-8">
                <span class="text-5xl">☕</span>
                <h1 class="font-serif text-3xl font-bold text-coffee-900 mt-3">Create Account</h1>
                <p class="text-coffee-600 text-sm font-light mt-1">Join The Coffee Shop family</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                           placeholder="Juan dela Cruz">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                           placeholder="you@example.com">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                           placeholder="••••••••">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 transition-colors"
                           placeholder="••••••••">
                </div>

                <button type="submit"
                        class="w-full bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-3.5 rounded-lg transition-colors">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-coffee-600 font-light mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-coffee-400 font-medium hover:underline">Sign in here</a>
            </p>
        </div>
    </div>
</section>

@endsection