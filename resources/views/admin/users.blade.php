@extends('layouts.app')

@section('title', 'Manage Users — Admin')

@section('content')
<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-coffee-400 uppercase tracking-widest text-xs mb-1">Admin Panel</p>
                <h1 class="font-serif text-4xl font-bold text-coffee-900">Users</h1>
            </div>
            <span class="text-coffee-600 text-sm">
                Total: <strong>{{ $users->count() }}</strong> users
            </span>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-coffee-50 border-b border-coffee-100">
                    <tr>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">#</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Name</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Email</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Role</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Joined</th>
                        <th class="text-left text-xs uppercase tracking-widest text-coffee-600 font-medium px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-coffee-400 text-sm">{{ $user->id }}</td>
                            <td class="px-6 py-4 font-medium text-coffee-900">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-coffee-400">(you)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-coffee-600 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->is_admin)
                                    <span class="bg-coffee-100 text-coffee-700 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                        Admin
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-coffee-600 text-sm">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-xs text-coffee-400 hover:text-coffee-600 font-medium uppercase tracking-wider">
                                                {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                                              onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-red-400 hover:text-red-600 font-medium uppercase tracking-wider">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-coffee-400 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</section>
@endsection