@extends('layouts.app')

@section('title', __('Products'))

@section('content')

    <div class="max-w-7xl mx-auto px-2 sm:px-4 py-2">

        <div id="products-grid" class="grid grid-cols-2 gap-2 sm:gap-3 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">

            @foreach ($products as $product)
                <div class="bg-white rounded-xl shadow-sm flex flex-col overflow-visible min-w-0">

                    <a href="{{ route('products.show', $product) }}">
                        <div
                            class="w-full aspect-square bg-white flex items-center justify-center p-2 sm:p-4 transition duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <img id="product-img-{{ $product->id }}" src="{{ asset($product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain">
                        </div>
                    </a>

                    <div class="p-2 sm:p-3 flex flex-col flex-grow text-center min-w-0">

                        <a href="{{ route('products.show', $product) }}"
                            class="text-sm sm:text-base font-semibold text-gray-900 truncate hover:text-blue-600 transition">
                            {{ $product->name }}
                        </a>

                        <div class="relative inline-block mt-1 group min-w-0">

                            <p class="text-xs sm:text-sm text-gray-600 truncate cursor-pointer">
                                {{ $product->description }}
                            </p>

                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 
                                       w-48 sm:w-64 p-3 rounded-lg bg-gray-900 text-white text-xs 
                                       opacity-0 invisible transition-all duration-200
                                       group-hover:opacity-100 group-hover:visible
                                       pointer-events-none shadow-lg z-50">
                                {{ $product->description }}
                            </div>

                        </div>

                        <div class="flex items-center justify-center gap-1 sm:gap-2 mt-1 flex-wrap">

                            @if ($product->old_price)
                                <span class="text-xs sm:text-sm text-gray-400 line-through">
                                    ${{ $product->old_price }}
                                </span>
                            @endif


                            <a href="{{ route('products.show', $product) }}"
                                class="font-semibold text-base sm:text-xl tracking-tight hover:text-blue-600 transition">
                                ${{ $product->price }}
                            </a>


                        </div>

                        <button
                            data-id="{{ $product->id }}"
                            class="add-to-cart-btn mt-2 sm:mt-3 bg-blue-600 text-white px-2 sm:px-4 py-1.5 sm:py-2 rounded text-xs sm:text-sm
                                 hover:bg-blue-700 transition duration-300
                                   active:scale-95 transform hover:-translate-y-1 w-full">
                            {{ __('Add to cart') }}
                        </button>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

@endsection
