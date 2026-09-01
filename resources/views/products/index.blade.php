@extends('layouts.app')

@section('title', __('Products'))

@section('content')

    <div class="max-w-7xl xl:max-w-[1600px] mx-auto px-3 sm:px-6 py-4">

        @if (($home ?? false))
            <section class="relative mb-16 sm:mb-28 pt-12 sm:pt-24 pb-6 overflow-hidden">
                <div class="absolute -top-32 -left-32 w-[32rem] h-[32rem] bg-green-300/30 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-10 -right-40 w-[36rem] h-[36rem] bg-amber-200/25 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative max-w-4xl mx-auto text-center">
                    <p class="rise-1 inline-flex items-center gap-2.5 bg-white/60 backdrop-blur-xl border border-white/70 rounded-full px-5 py-2 text-xs sm:text-sm font-semibold text-gray-600 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        {{ __('Tech, fashion and home in one place') }}
                    </p>

                    <h1 class="rise-2 mt-7 text-5xl sm:text-7xl font-extrabold tracking-tight text-gray-900 leading-[1.02]">
                        {{ __('Discover products') }}
                        <span class="bg-gradient-to-r from-green-600 to-emerald-500 bg-clip-text text-transparent">{{ __("you'll love") }}</span>
                    </h1>

                    <p class="rise-3 mt-6 text-lg sm:text-2xl text-gray-500 max-w-2xl mx-auto leading-relaxed font-light">
                        {{ __('Quality products, fair prices and fast shipping straight to your door.') }}
                    </p>

                    <div class="rise-4 mt-10 flex flex-col sm:flex-row items-center justify-center gap-3.5">
                        <a href="/products"
                            class="w-full sm:w-auto bg-white/60 backdrop-blur-xl border border-white/70 text-gray-700 px-10 py-4 rounded-full text-base font-bold hover:bg-white/90 hover:-translate-y-0.5 active:scale-95 transition-all shadow-sm">
                            {{ __('Browse catalog') }}
                        </a>
                    </div>

                    <div class="rise-4 mt-12 flex flex-wrap items-center justify-center gap-3">
                        <span class="inline-flex items-center gap-2.5 bg-white/60 backdrop-blur-xl border border-white/70 rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            {{ __('Free shipping nationwide') }}
                        </span>
                        <span class="inline-flex items-center gap-2.5 bg-white/60 backdrop-blur-xl border border-white/70 rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            {{ __('Secure payments') }}
                        </span>
                        <span class="inline-flex items-center gap-2.5 bg-white/60 backdrop-blur-xl border border-white/70 rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0m18 0c0 1.657-1.007 3-2.25 3S16.5 13.657 16.5 12m4.5 0c0-4.552-3.448-8.25-7.714-8.25M12 21a9 9 0 01-9-9m9 9c-1.657 0-3-1.007-3-2.25"/></svg>
                            {{ __('24/7 support') }}
                        </span>
                    </div>
                </div>
            </section>

            <div class="flex items-end justify-between mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">{{ __('Featured products') }}</h2>
                <a href="/products" class="text-sm font-semibold text-green-600 hover:text-green-700 transition-colors">
                    {{ __('View all') }} <span aria-hidden="true">→</span>
                </a>
            </div>
        @endif

        <div id="products-grid" class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4 lg:gap-8">

            @foreach ($products as $product)
                <div class="group relative bg-white/70 backdrop-blur-xl border border-white/70 rounded-3xl shadow-[0_2px_16px_rgba(0,0,0,0.04)] hover:shadow-[0_24px_48px_-16px_rgba(0,0,0,0.15)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col overflow-hidden">

                    @if ($product->old_price && $product->old_price > $product->price)
                        <span class="absolute top-3 left-3 z-10 bg-red-500/90 backdrop-blur-sm text-white text-[10px] sm:text-xs font-bold px-2 py-1 rounded-full shadow-lg shadow-red-500/25">
                            -{{ (int) round((1 - $product->price / $product->old_price) * 100) }}%
                        </span>
                    @endif

                    <button type="button" data-id="{{ $product->id }}" title="{{ __('Add to wishlist') }}"
                        class="wishlist-btn absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/70 backdrop-blur-md border border-white/80 shadow-sm flex items-center justify-center hover:scale-110 active:scale-90 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" fill="none"
                            class="w-4 h-4 {{ in_array($product->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </button>

                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="w-full aspect-square bg-gradient-to-b from-white to-gray-50 flex items-center justify-center p-4 sm:p-8 overflow-hidden">
                            <img id="product-img-{{ $product->id }}" src="{{ asset($product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain transition-transform duration-700 ease-out group-hover:scale-105">
                        </div>
                    </a>

                    <div class="p-3 sm:p-5 flex flex-col flex-grow min-w-0 bg-white/50 border-t border-white/60">

                        @if ($product->brand)
                            <p class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-gray-400 truncate">
                                {{ \Illuminate\Support\Str::before($product->brand, ',') }}
                            </p>
                        @endif

                        <a href="{{ route('products.show', $product) }}"
                            class="mt-1 text-sm sm:text-base font-bold text-gray-900 truncate group-hover:text-green-600 transition-colors">
                            {{ $product->name }}
                        </a>

                        @if (($product->ratings_count ?? 0) > 0)
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <div class="flex text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($product->ratings_avg) ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.5.04.7.663.32.988l-4.204 3.604a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.604a.563.563 0 01.32-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-[11px] font-semibold text-gray-400">({{ $product->ratings_count }})</span>
                            </div>
                        @endif

                        <div class="flex items-baseline gap-2 mt-2 sm:mt-3 flex-wrap">
                            <span class="text-base sm:text-xl font-extrabold tracking-tight text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            @if ($product->old_price && $product->old_price > $product->price)
                                <span class="text-xs sm:text-sm text-gray-400 line-through font-medium">
                                    ${{ number_format($product->old_price, 2) }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-auto pt-1.5 min-h-[20px]">
                            @if ($product->stock === 0)
                                <span class="inline-block bg-red-50 text-red-500 text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full border border-red-100">
                                    {{ __('Out of stock') }}
                                </span>
                            @elseif ($product->stock <= 3)
                                <span class="inline-block bg-amber-50 text-amber-600 text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full border border-amber-100">
                                    {{ __('Only :n left!', ['n' => $product->stock]) }}
                                </span>
                            @endif
                        </div>

                        @if ($product->stock > 0)
                            <button
                                data-id="{{ $product->id }}"
                                class="add-to-cart-btn mt-2 sm:mt-3 bg-gradient-to-br from-green-600 to-emerald-600 text-white px-3 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-bold shadow-lg shadow-green-600/25
                                       hover:shadow-green-600/45 hover:brightness-105 active:scale-95 transition-all duration-300 w-full">
                                {{ __('Add to cart') }}
                            </button>
                        @else
                            <span
                                class="mt-2 sm:mt-3 bg-gray-100/80 text-gray-400 px-3 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-bold w-full block text-center cursor-not-allowed">
                                {{ __('Out of stock') }}
                            </span>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </div>

@endsection
