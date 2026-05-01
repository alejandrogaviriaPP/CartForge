@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-2">

    <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-4">

        @foreach($products as $product)
        <div class="bg-white rounded-xl shadow-sm flex flex-col overflow-visible group">

            <!-- Imagen -->
            <div class="w-full aspect-square bg-white flex items-center justify-center p-0 transition duration-300 transform hover:-translate-y-1">
                <img src="{{ asset($product->image) }}" 
                     class="max-h-full object-contain">
            </div>

            <div class="p-2 flex flex-col flex-grow text-center relative">

                <h2 class="text-base font-semibold text-gray-900">
                    {{ $product->name }}
                </h2>

                <p class="text-sm text-gray-600 mt-1 truncate">
                    {{ $product->description }}
                </p>

                <!-- Tooltip -->
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 
                            w-64 p-3 rounded-lg bg-gray-900 text-white text-xs 
                            opacity-0 group-hover:opacity-100 
                            transition duration-300 pointer-events-none shadow-lg">
                    {{ $product->description }}
                </div>

                <span class="mt-2 text-lg font-bold text-gray-900">
                    ${{ number_format($product->price, 2) }}
                </span>


                <button
                    onclick="addToCart({{ $product->id }})"
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700
                     transition duration-300 transform hover:-translate-y-1">
                    Add to cart
                </button>

            </div>

        </div>
        @endforeach

    </div>

</div>

@endsection