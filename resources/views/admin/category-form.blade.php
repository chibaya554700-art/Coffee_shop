@extends('layouts.app')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-xl mx-auto px-6">

        <div class="mb-8">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">
                {{ isset($category) ? 'Edit Category' : 'Add Category' }}
            </h1>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-8">
            <form method="POST"
                  action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                @csrf
                @if(isset($category)) @method('PUT') @endif

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Category Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $category->name ?? '') }}" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Slug</label>
                    <input type="text" name="slug"
                           value="{{ old('slug', $category->slug ?? '') }}" required
                           placeholder="hot-drinks"
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    <p class="text-xs text-coffee-400 mt-1">Lowercase with hyphens e.g. hot-drinks</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Icon (Emoji)</label>
                    <input type="text" name="icon"
                           value="{{ old('icon', $category->icon ?? '') }}"
                           placeholder="☕"
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    <p class="text-xs text-coffee-400 mt-1">Paste an emoji e.g. ☕ 🧋 🍵 🥐</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                        {{ isset($category) ? 'Update Category' : 'Add Category' }}
                    </button>
                    <a href="{{ route('admin.categories') }}"
                       class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection