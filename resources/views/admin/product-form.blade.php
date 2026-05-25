@extends('layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-2xl mx-auto px-6">

        <div class="mb-8">
            <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
            <h1 class="font-serif text-4xl font-bold text-coffee-900">
                {{ isset($product) ? 'Edit Product' : 'Add Product' }}
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
                  action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Category</label>
                    <select name="category_id" required
                            class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Price (₱)</label>
                    <input type="number" name="price" step="0.01"
                           value="{{ old('price', $product->price ?? '') }}" required
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 resize-none">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-coffee-800 mb-1.5">Product Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="w-20 h-20 object-cover rounded-lg">
                        </div>
                    @endif
                </div>

                <div class="mb-5 flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <span class="text-sm text-coffee-700">Featured product</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_available" value="1"
                               {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
                        <span class="text-sm text-coffee-700">Available</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                        {{ isset($product) ? 'Update Product' : 'Add Product' }}
                    </button>
                    <a href="{{ route('admin.products') }}"
                       class="border border-coffee-400 text-coffee-400 hover:bg-coffee-400 hover:text-cream font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection