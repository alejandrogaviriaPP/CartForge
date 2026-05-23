@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">Shopping Cart</h1>

    @php $total = 0; @endphp

    @forelse($cart as $id => $item)

    @php 
        $subtotal = $item['price'] * $item['quantity']; 
        $total += $subtotal; 
    @endphp

    <div id="item-{{ $id }}" class="flex items-center justify-between bg-white p-4 rounded-lg shadow mb-4">

        <div class="flex items-center gap-4">

            <img src="{{ asset($item['image']) }}" class="w-20 h-20 object-contain">

            <div>
                <h2 class="font-semibold">{{ $item['name'] }}</h2>

                <p class="text-gray-500 text-sm">
                    ${{ number_format($item['price'], 2, '.', ',') }}
                </p>

                <div class="mt-2 flex items-center gap-2">

                    <button type="button"
                        onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
                        class="w-8 h-8 border rounded hover:bg-gray-100">
                        −
                    </button>

                    <span class="px-3 py-1 bg-gray-100 rounded">
                        {{ $item['quantity'] }}
                    </span>

                    <button type="button"
                        onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                        class="w-8 h-8 bg-blue-600 text-white rounded hover:bg-blue-700">
                        +
                    </button>

                </div>
            </div>

        </div>

        <div class="text-right">

            <p class="font-bold text-lg">
                ${{ number_format($subtotal, 2, '.', ',') }}
            </p>

            <button type="button"
                onclick="removeFromCart({{ $id }})"
                class="text-red-500 text-sm mt-2 hover:underline">
                Remove
            </button>

        </div>

    </div>

    @empty
        <p class="text-center">Your cart is empty.</p>
    @endforelse

    <div class="mt-6 text-right">

        <h2 id="cart-total" class="text-xl font-bold">
    Total: ${{ number_format($total, 2, '.', ',') }}
</h2>
<button id="real-checkout-btn" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition">
    Checkout
</button>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('real-checkout-btn');
        if (btn) {
            btn.onclick = function() {
                if (typeof window.checkout === 'function') {
                    window.checkout();
                } else {
                    console.error("La función checkout no ha cargado aún.");
                }
            };
        }
    });
</script>

    </div>

</div>

@endsection