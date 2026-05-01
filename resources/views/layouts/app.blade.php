<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CartForge')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<script>
function addToCart(id) {

    fetch(`/cart/add/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById("cart-count").innerText = data.cartCount;
        }
    });

}
</script>
<div id="toast"
     class="fixed bottom-5 right-5 z-[9999] bg-green-600 text-white px-4 py-3 rounded-lg shadow-xl opacity-0 pointer-events-none transition-all duration-300">
    Product added to cart 🛒
</div>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <!-- IZQUIERDA -->
        <div class="flex items-center gap-5 font-semibold">
            <a href="" class="text-xl ">
                CartForge
            </a>

            <a href="/products" class=" hover:text-black ">
                Products
            </a>

            <a href="start">Home</a>
        </div>

        <div>
            <a href="{{ route('cart.index') }}" class="relative">
    🛒

    <span id="cart-count"
          class="absolute -top-2 -right-2 bg-gray-500 text-white text-xs rounded-full px-2">
        {{ $cartCount ?? 0 }}
    </span>
</a>
        </div>

    </div>
</nav>


    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>

</body>
</html>