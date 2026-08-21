@extends('layouts.app')

@section('title', __('Cart'))

@section('content')

    <div class="max-w-4xl mx-auto p-3 sm:p-6">

        <h1 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-center">{{ __('Shopping Cart') }}</h1>

        @forelse($cart as $id => $item)
            <div id="item-{{ $id }}" class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-3 sm:p-4 rounded-lg shadow mb-3 sm:mb-4 gap-3 sm:gap-4">

                <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                        class="w-14 h-14 sm:w-20 sm:h-20 object-contain shrink-0 rounded-lg">

                    <div class="min-w-0">
                        <h2 class="font-semibold text-sm sm:text-base truncate">{{ $item['name'] }}</h2>

                        <p class="text-gray-500 text-xs sm:text-sm">
                            ${{ number_format($item['price'], 2, '.', ',') }}
                        </p>

                        <div class="mt-2 flex items-center gap-2">

                            <button type="button"
                                onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
                                class="w-7 h-7 sm:w-8 sm:h-8 border rounded hover:bg-gray-100 flex items-center justify-center">
                                −
                            </button>

                            <span class="px-2 sm:px-3 py-1 bg-gray-100 rounded text-sm">
                                {{ $item['quantity'] }}
                            </span>

                            <button type="button"
                                onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                                class="w-7 h-7 sm:w-8 sm:h-8 bg-green-600 text-white rounded flex items-center justify-center">
                                +
                            </button>

                        </div>
                    </div>

                </div>

                <div class="text-left sm:text-right flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-2 sm:gap-0 shrink-0">

                    <p class="font-bold text-base sm:text-lg">
                        ${{ number_format($item['subtotal'], 2, '.', ',') }}
                    </p>

                    <button type="button" onclick="removeFromCart({{ $id }})"
                        class="text-red-500 text-xs sm:text-sm mt-0 sm:mt-2 hover:underline">
                        {{ __('Remove') }}
                    </button>

                </div>

            </div>

        @empty
            <p class="text-center text-sm sm:text-base">{{ __('Your cart is empty.') }}</p>
        @endforelse

        <div class="mt-4 sm:mt-6 text-right">

            <h2 id="cart-total" class="text-lg sm:text-xl font-bold">
                {{ __('Total:') }} ${{ number_format($total, 2, '.', ',') }}
            </h2>
            <button id="real-checkout-btn"
                class="bg-green-600 text-white px-4 sm:px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition text-sm sm:text-base">
                {{ __('Checkout') }}
            </button>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('real-checkout-btn');
                    if (btn) {
                        btn.onclick = function() {
                            if (typeof window.checkout === 'function') {
                                window.checkout();
                            } else {
                                console.error("The checkout function has not yet loaded.");
                            }
                        };
                    }
                });
            </script>

        </div>

    </div>

@endsection