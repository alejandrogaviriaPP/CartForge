@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-2">

        <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-4">

            @foreach ($products as $product)
                <div class="bg-white rounded-xl shadow-sm flex flex-col overflow-visible">

                    <div
                        class="w-full aspect-square bg-white flex items-center justify-center p-0 transition duration-300 transform hover:-translate-y-2">
                        <img id="product-img-{{ $product->id }}" src="{{ asset($product->image) }}"
                            class="max-h-full object-contain">
                    </div>

                    <div class="p-2 flex flex-col flex-grow text-center">

                        <h2 class="text-base font-semibold text-gray-900">
                            {{ $product->name }}
                        </h2>

                        <div class="relative inline-block mt-1 group">

                            <p class="text-sm text-gray-600 truncate cursor-pointer">
                                {{ $product->description }}
                            </p>

                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 
                                       w-64 p-3 rounded-lg bg-gray-900 text-white text-xs 
                                       opacity-0 invisible transition-all duration-200
                                       group-hover:opacity-100 group-hover:visible
                                       pointer-events-none shadow-lg z-50">
                                {{ $product->description }}
                            </div>

                        </div>

                        <div class="flex items-center justify-center gap-2 mt-1">

                            @if ($product->old_price)
                                <span class="text-sm text-gray-400 line-through">
                                    ${{ $product->old_price }}
                                </span>
                            @endif


                            <span class="font-semibold text-xl tracking-tight">
                                ${{ $product->price }}

                            </span>


                        </div>

                        <button
                            class="add-to-cart-btn mt-3 bg-blue-600 text-white px-4 py-2 rounded
                                 hover:bg-blue-700 transition duration-300
                                   active:scale-95 transform hover:-translate-y-1"
                            data-id="{{ $product->id }}">
                            Add to cart
                        </button>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

@endsection
