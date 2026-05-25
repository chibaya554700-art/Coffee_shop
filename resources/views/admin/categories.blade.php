@extends('layouts.app')

@section('title', 'Manage Categories — Admin')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-5xl mx-auto px-6">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
                <h1 class="font-serif text-4xl font-bold text-coffee-900">Categories</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm text-coffee-400 hover:underline">← Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-8">

            {{-- Add Category Form --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Add New Category</h2>
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Name</label>
                        <input type="text" name="name" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400"
                               placeholder="e.g. Hot Drinks">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Slug</label>
                        <input type="text" name="slug" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400"
                               placeholder="e.g. hot-drinks">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Icon (emoji)</label>
                        <input type="text" name="icon"
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400"
                               placeholder="e.g. ☕">
                    </div>
                    <button type="submit"
                            class="w-full bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-3 rounded-lg transition-colors">
                        Add Category
                    </button>
                </form>
            </div>

            {{-- Categories List --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full">
                    <thead class="bg-coffee-50 border-b border-coffee-100">
                        <tr>
                            <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Category</th>
                            <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Products</th>
                            <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-50">
                        @foreach($categories as $category)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">{{ $category->icon ?? '☕' }}</span>
                                        <div>
                                            <p class="font-medium text-coffee-900">{{ $category->name }}</p>
                                            <p class="text-xs text-coffee-400">{{ $category->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-coffee-600">{{ $category->products_count }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <button onclick="openEdit({{ $category->id }})"
                                                class="text-xs text-coffee-400 hover:text-coffee-600 font-medium uppercase tracking-wider">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.categories.delete', $category) }}" method="POST"
                                              onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-red-400 hover:text-red-600 font-medium uppercase tracking-wider">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div id="edit-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md mx-4">
                <h2 class="font-serif text-xl font-bold text-coffee-900 mb-6">Edit Category</h2>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Name</label>
                        <input type="text" id="edit-name" name="name" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Slug</label>
                        <input type="text" id="edit-slug" name="slug" required
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-coffee-800 mb-1.5">Icon (emoji)</label>
                        <input type="text" id="edit-icon" name="icon"
                               class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit"
                                class="flex-1 bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm py-3 rounded-lg transition-colors">
                            Update
                        </button>
                        <button type="button" onclick="closeEdit()"
                                class="flex-1 border border-coffee-400 text-coffee-400 font-bold uppercase tracking-widest text-sm py-3 rounded-lg transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
    const categories = @json($categories->keyBy('id'));

    function openEdit(id) {
        const cat = categories[id];
        document.getElementById('edit-name').value = cat.name;
        document.getElementById('edit-slug').value = cat.slug;
        document.getElementById('edit-icon').value = cat.icon ?? '';
        document.getElementById('edit-form').action = '/admin/categories/' + id;
        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEdit() {
        document.getElementById('edit-modal').classList.add('hidden');
    }
</script>
@endpush

@endsection