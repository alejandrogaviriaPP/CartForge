@extends('layouts.app')

@section('title', __('Products'))

@section('content')

    <div class="max-w-7xl xl:max-w-[1600px] mx-auto px-3 sm:px-6 py-4">

        <div id="products-grid" class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4 lg:gap-8">

            @foreach ($products as $product)
                <div class="bg-white rounded-xl shadow-sm flex flex-col overflow-visible min-w-0 relative">

                    <button type="button" data-id="{{ $product->id }}" title="{{ __('Add to wishlist') }}"
                        class="wishlist-btn absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm shadow-sm flex items-center justify-center hover:scale-110 active:scale-95 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" fill="none"
                            class="w-4 h-4 {{ in_array($product->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </button>

                    <a href="{{ route('products.show', $product) }}">
                        <div
                            class="w-full aspect-square bg-white flex items-center justify-center p-3 sm:p-6 transition duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <img id="product-img-{{ $product->id }}" src="{{ asset($product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain">
                        </div>
                    </a>

                    <div class="p-2 sm:p-4 flex flex-col flex-grow text-center min-w-0">

                        <a href="{{ route('products.show', $product) }}"
                            class="text-sm sm:text-lg font-semibold text-gray-900 truncate hover:text-blue-600 transition">
                            {{ $product->name }}
                        </a>

                        <div class="relative inline-block mt-1 group min-w-0">

                            <p class="text-xs sm:text-base text-gray-600 truncate cursor-pointer">
                                {{ $product->description }}
                            </p>

                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 
                                       w-48 sm:w-64 p-3 rounded-lg bg-gray-900 backdrop-blur-md text-white text-xs 
                                       opacity-0 invisible transition-all duration-200
                                       group-hover:opacity-100 group-hover:visible
                                       pointer-events-none shadow-lg z-50">
                                {{ $product->description }}
                            </div>

                        </div>

                        <div class="flex items-center justify-center gap-1 sm:gap-2 mt-1 flex-wrap">

                            @if ($product->old_price)
                                <span class="text-xs sm:text-base text-gray-400 line-through">
                                    ${{ $product->old_price }}
                                </span>
                            @endif


                            <a href="{{ route('products.show', $product) }}"
                                class="font-semibold text-base sm:text-2xl tracking-tight hover:text-blue-600 transition">
                                ${{ $product->price }}
                            </a>


                        </div>

                        <button
                            data-id="{{ $product->id }}"
                            class="add-to-cart-btn mt-2 sm:mt-3 bg-green-600 text-white px-3 py-2 sm:py-2.5 rounded-lg text-xs sm:text-base
                                 transition duration-300
                                   active:scale-95 transform hover:-translate-y-1 w-full">
                            {{ __('Add to cart') }}
                        </button>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

@endsection
