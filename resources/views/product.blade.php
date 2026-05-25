@extends('layouts.app')

@section('title', $product->name . ' — The Coffee Shop')

@section('content')

<section class="min-h-screen bg-cream pt-32 pb-16">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Product Detail Card --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-12">
            <div class="grid md:grid-cols-2">

                {{-- Image --}}
                <div class="h-72 md:h-auto bg-gradient-to-br from-coffee-100 to-coffee-200 flex items-center justify-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-9xl opacity-20">☕</span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-10 flex flex-col justify-center">
                    <span class="text-xs text-coffee-400 uppercase tracking-widest font-medium mb-2">
                        {{ $product->category->name }}
                    </span>
                    <h1 class="font-serif text-4xl font-bold text-coffee-900 mb-4">
                        {{ $product->name }}
                    </h1>
                    <p class="text-coffee-600 font-light leading-relaxed mb-6">
                        {{ $product->description ?? 'No description available.' }}
                    </p>
                    <p class="font-serif text-3xl font-bold text-coffee-400 mb-8">
                        ₱{{ number_format($product->price, 2) }}
                    </p>

                    @if(!$product->is_available)
                        <span class="inline-block bg-red-100 text-red-500 text-sm font-bold px-4 py-2 rounded-lg">
                            Currently Unavailable
                        </span>
                    @else
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full md:w-auto bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-10 py-4 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </form>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('menu') }}"
                       class="inline-block mt-4 text-sm text-coffee-400 hover:underline">
                        ← Back to Menu
                    </a>
                </div>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-12">

            <h2 class="font-serif text-2xl font-bold text-coffee-900 mb-2">
                Customer Reviews
            </h2>

            {{-- Average Rating --}}
            @php $avg = round($product->averageRating(), 1); @endphp
            <div class="flex items-center gap-3 mb-8">
                <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $avg ? 'text-yellow-400' : 'text-coffee-200' }} text-2xl">★</span>
                    @endfor
                </div>
                <span class="text-coffee-600 text-sm">
                    {{ $avg ?: 'No ratings yet' }} / 5
                    ({{ $product->reviews->count() }} {{ Str::plural('review', $product->reviews->count()) }})
                </span>
            </div>

            {{-- Messages --}}
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

            {{-- Review Form --}}
            @auth
                @if(!$product->reviews->where('user_id', Auth::id())->count())
                    <div class="bg-coffee-50 rounded-xl p-6 mb-8">
                        <h3 class="font-serif text-lg font-bold text-coffee-900 mb-4">Leave a Review</h3>
                        <form action="{{ route('review.store', $product->id) }}" method="POST">
                            @csrf

                            {{-- Star Rating --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-coffee-800 mb-2">Rating</label>
                                <div class="flex gap-2" id="star-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer" data-index="{{ $i }}">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden star-input" required>
                                            <span class="text-3xl transition-colors star-label" style="color: #e5d5b0;">★</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-coffee-800 mb-1.5">Comment (optional)</label>
                                <textarea name="comment" rows="3" placeholder="Share your experience..."
                                          class="w-full border border-coffee-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-coffee-400 resize-none"></textarea>
                            </div>

                            <button type="submit"
                                    class="bg-coffee-400 hover:bg-coffee-600 text-cream font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-lg transition-colors">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div class="bg-coffee-50 rounded-xl p-6 mb-8 text-center">
                    <p class="text-coffee-600 text-sm">
                        <a href="{{ route('login') }}" class="text-coffee-400 font-bold hover:underline">Login</a>
                        to leave a review.
                    </p>
                </div>
            @endauth

            {{-- Reviews List --}}
            @if($product->reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($product->reviews as $review)
                        <div class="border-b border-coffee-50 pb-6">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-bold text-coffee-900">{{ $review->user->name }}</p>
                                    <div class="flex gap-0.5 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-coffee-200' }} text-sm">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-coffee-400">
                                        {{ $review->created_at->format('M d, Y') }}
                                    </span>
                                    @auth
                                        @if(Auth::id() === $review->user_id)
                                            <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs text-red-400 hover:text-red-600 font-medium transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-coffee-600 text-sm leading-relaxed mt-2">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-coffee-400 text-sm text-center py-8">No reviews yet. Be the first to review!</p>
            @endif
        </div>

        {{-- Related Products --}}
        @if($related->count() > 0)
            <div>
                <h2 class="font-serif text-2xl font-bold text-coffee-900 mb-6">You Might Also Like</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $item)
                        <a href="{{ route('product.show', $item->id) }}"
                           class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                            <div class="h-36 bg-gradient-to-br from-coffee-100 to-coffee-200 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         alt="{{ $item->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-5xl opacity-20">☕</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-serif font-bold text-coffee-900">{{ $item->name }}</h3>
                                <p class="text-coffee-400 font-bold text-sm mt-1">₱{{ number_format($item->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
    const starLabels = document.querySelectorAll('.star-label');
    const starInputs  = document.querySelectorAll('.star-input');
    let selectedIndex = -1;

    starLabels.forEach((star, index) => {
        // Highlight on hover
        star.addEventListener('mouseover', () => {
            starLabels.forEach((s, i) => {
                s.style.color = i <= index ? '#f59e0b' : '#e5d5b0';
            });
        });

        // Reset to selected on mouse out
        star.addEventListener('mouseout', () => {
            starLabels.forEach((s, i) => {
                s.style.color = i <= selectedIndex ? '#f59e0b' : '#e5d5b0';
            });
        });

        // Select on click
        star.addEventListener('click', () => {
            selectedIndex = index;
            starInputs[index].checked = true;
            starLabels.forEach((s, i) => {
                s.style.color = i <= index ? '#f59e0b' : '#e5d5b0';
            });
        });
    });
</script>
@endpush

@endsection