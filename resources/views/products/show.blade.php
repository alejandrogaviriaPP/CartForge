@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-6 py-4">

        <a href="{{ url()->previous() ?: route('products.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-900 mb-4 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back') }}
        </a>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                <div class="p-4 sm:p-8">
                    @auth
                        <button type="button" id="open-rating-modal" class="w-full text-left cursor-pointer">
                    @endauth
                    <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center mb-4">
                        <img id="main-image" src="{{ asset($images[0]) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain transition-opacity duration-300">
                    </div>
                    @auth
                        </button>
                    @endauth

                    @if (count($images) > 1)
                        <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2">
                            @foreach ($images as $index => $image)
                                <button type="button" data-image="{{ asset($image) }}"
                                    class="gallery-thumb shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg border-2 overflow-hidden bg-white flex items-center justify-center transition {{ $loop->first ? 'border-green-600' : 'border-gray-200 hover:border-gray-400' }}">
                                    <img src="{{ asset($image) }}" alt="{{ $product->name }} - {{ $index + 1 }}"
                                        class="w-full h-full object-contain">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-4 sm:p-8 lg:border-l border-gray-100 flex flex-col">

                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                        @if ($product->brand)
                            {{ $product->brand }}
                        @elseif ($product->category)
                            {{ ucfirst($product->category) }}
                        @endif
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center gap-2 mb-4">

                        <div class="flex items-center" aria-label="{{ __('Ratings') }}">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 {{ $i <= round($average) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-gray-300' }}"
                                    viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                                </svg>
                            @endfor
                        </div>

                        <span id="rating-average" class="text-sm font-semibold text-gray-900">{{ $average > 0 ? number_format($average, 1) : '—' }}</span>
                        <span id="rating-count" class="text-sm text-gray-500">
                            ({{ $count > 0 ? $count . ' ' . ($count === 1 ? __('rating') : __('ratings')) : __('No ratings yet') }})
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        @if ($product->old_price)
                            <span class="text-lg text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</span>
                        @endif
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ __('Description') }}</h3>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-auto">

                        <button type="button"
                            data-id="{{ $product->id }}"
                            class="add-to-cart-btn flex-1 bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 active:scale-95 transition">
                            {{ __('Add to cart') }}
                        </button>

                        <button type="button" data-id="{{ $product->id }}" title="{{ __('Add to wishlist') }}"
                            class="wishlist-btn shrink-0 w-12 h-12 rounded-xl border border-gray-200 bg-white flex items-center justify-center hover:scale-105 active:scale-95 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" fill="none"
                                class="w-5 h-5 {{ in_array($product->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-500' }}">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>

                        @auth
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-500 mb-1.5">{{ __('Rate this product') }}</p>
                                <div class="flex items-center gap-1" id="star-rating" data-product-id="{{ $product->id }}"
                                    data-user-rating="{{ $userRating?->rating ?? 0 }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" data-value="{{ $i }}"
                                            class="rating-star p-0.5 transition hover:scale-110 focus:outline-none"
                                            aria-label="{{ $i }} {{ __('rating') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-7 h-7 {{ $userRating && $i <= $userRating->rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-gray-300 hover:text-yellow-400 hover:fill-yellow-400' }}"
                                                viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="flex-1 border-2 border-gray-200 text-gray-600 px-6 py-3 rounded-xl font-semibold text-center hover:border-green-600 hover:text-green-600 transition">
                                {{ __('Login to rate') }}
                            </a>
                        @endauth

                    </div>

                </div>

            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('Reviews') }} (<span id="reviews-count">{{ $count }}</span>)</h2>

                <div id="reviews-list">
                    @forelse ($product->ratings->sortByDesc('updated_at') as $rating)
                        <div class="border-b border-gray-100 py-4 last:border-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ strtoupper(substr($rating->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-sm text-gray-900">{{ $rating->user?->name ?? '—' }}</span>
                                </div>
                                <span class="text-xs text-gray-400">{{ $rating->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-gray-300' }}"
                                        viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                                    </svg>
                                @endfor
                            </div>
                            @if ($rating->comment)
                                <p class="text-sm text-gray-700 mt-2 leading-relaxed">{{ $rating->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('No reviews yet') }}</p>
                        <p class="text-gray-400 text-xs text-center pb-4">{{ __('be the first to review') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 h-fit">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('Ratings') }}</h2>

                @if ($count > 0)
                    @foreach ($ratingBreakdown as $star => $breakdown)
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-medium text-gray-600 w-3">{{ $star }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                            </svg>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $breakdown['percentage'] }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 w-6 text-right">{{ $breakdown['count'] }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-sm text-center py-8">{{ __('No ratings yet') }}</p>
                @endif
            </div>

        </div>

        @if ($related->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Related Products') }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6">
                    @foreach ($related as $item)
                        <a href="{{ route('products.show', $item) }}"
                            class="bg-white rounded-xl shadow-sm p-3 sm:p-4 hover:shadow-md transition group">
                            <div class="aspect-square bg-white flex items-center justify-center overflow-hidden mb-2">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $item->name }}</h3>
                            <p class="text-sm font-bold text-gray-900 mt-1">${{ number_format($item->price, 2) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    @auth
        <div id="rating-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" data-close-rating-modal></div>
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 sm:p-8">
                <button type="button" data-close-rating-modal
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ __('Rate this product') }}</h3>
                <p class="text-sm text-gray-500 mb-5">{{ $product->name }}</p>

                <div class="flex items-center justify-center gap-2 mb-6" id="modal-star-rating"
                    data-product-id="{{ $product->id }}" data-user-rating="{{ $userRating?->rating ?? 0 }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" data-value="{{ $i }}"
                            class="modal-rating-star p-1 transition hover:scale-110 focus:outline-none"
                            aria-label="{{ $i }} {{ __('rating') }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 {{ $userRating && $i <= $userRating->rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-gray-300 hover:text-yellow-400 hover:fill-yellow-400' }}"
                                viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                            </svg>
                        </button>
                    @endfor
                </div>

                <div class="mb-5">
                    <label for="rating-comment" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Your comment') }}
                    </label>
                    <textarea id="rating-comment" rows="4"
                        placeholder="{{ __('Write a comment about this product...') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm resize-none">{{ $userRating?->comment ?? '' }}</textarea>
                </div>

                <button type="button" id="submit-rating"
                    class="w-full bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 active:scale-95 transition">
                    {{ __('Submit rating') }}
                </button>
            </div>
        </div>
    @endauth
@endsection
