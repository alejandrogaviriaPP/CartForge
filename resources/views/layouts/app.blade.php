<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CartForge')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    </script>
</head>

<body class="bg-gray-100 font-sans">

<div id="toast"
     class="fixed bottom-6 right-6 z-[9999]
            bg-blue-500/80 backdrop-blur-md text-white
            px-5 py-3 rounded-2xl shadow-xl
            opacity-0 translate-y-10 scale-90
            pointer-events-none
            transition-all duration-500 ease-out">
</div>

<div id="search-overlay"
     class="fixed inset-0 z-40 
            bg-white/70 backdrop-blur-xl 
            opacity-0 pointer-events-none 
            transition-opacity duration-200 ease-out">

    <!-- CONTENT (Inicia desplazado hacia arriba) -->
    <div id="search-content"
         class="max-w-5xl mx-auto pt-24 px-8 
       -translate-y-20 opacity-0 
      transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]">

        <form action="{{ route('products.index') }}" method="GET" class="mb-16">
            <div class="flex items-center gap-5 border-b border-gray-300 pb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <input type="text" 
                       name="search" 
                       placeholder="Search products"
                       class="w-full bg-transparent text-5xl font-light tracking-tight placeholder:text-gray-300 focus:outline-none text-gray-900">

                <button type="button" id="close-search"
                        class="w-12 h-12 rounded-full bg-gray-200/50 hover:bg-gray-200 transition flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-24">
            
            <div class="flex flex-col gap-8">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Quick Links</p>
                <div class="flex flex-col gap-5">
                    <a href="/products?category=tech" class="text-3xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">Tech</a>
                    <a href="/products?category=fashion" class="text-3xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">Fashion</a>
                    <a href="/products?category=home" class="text-3xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">Home</a>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Popular</p>
                <div class="flex flex-col gap-4">
                    <a href="/products?search=apple" class="text-sm font-medium text-gray-600 hover:text-black transition">Apple Products</a>
                    <a href="/products?search=tv" class="text-sm font-medium text-gray-600 hover:text-black transition">Smart TV Accessories</a>
                    <a href="/products?search=headphones" class="text-sm font-medium text-gray-600 hover:text-black transition">Wireless Headphones</a>
                    <a href="/products?search=watch" class="text-sm font-medium text-gray-600 hover:text-black transition">Smart Watches</a>
                </div>
            </div>

            <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100">
                <p class="text-sm font-semibold text-gray-900 mb-2">New Arrivals</p>
                <p class="text-xs text-gray-500 leading-relaxed mb-4">Check out our latest tech and lifestyle releases for this season.</p>
                <a href="/products" class="text-blue-600 text-xs font-bold hover:underline">See what's new →</a>
            </div>

        </div>
    </div>
</div>



<nav class="bg-white border-b sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <!-- LEFT -->
        <div class="flex items-center gap-6 font-medium">

            <a href="/products"
               class="text-xl font-semibold tracking-tight">
                CartForge
            </a>

            <a href="/products"
               class="hover:text-black transition">
                Products
            </a>

            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="text-red-500 ">
                    Logout
                </button>
            </form>
            @endauth

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-6">

            <!-- SEARCH BUTTON -->
            <button id="search-btn"
                    class="text-gray-700 hover:text-black transition hover:scale-110 active:scale-95">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.7"
                     stroke="currentColor"
                     class="w-5 h-5">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-4.35-4.35m1.85-5.15
                             a7 7 0 1 1-14 0
                             a7 7 0 0 1 14 0Z"/>
                </svg>

            </button>

            @auth

            <a href="{{ route('cart.index') }}"
               class="relative hover:scale_105 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.7"
                     stroke="currentColor"
                     class="w-5 h-5 text-black/80">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 3h1.386a1.5 1.5 0 0 1 1.415 1.022L5.383 5.25m0 0h13.867
                             a1.5 1.5 0 0 1 1.464 1.825l-1.5 7.5
                             a1.5 1.5 0 0 1-1.464 1.175H8.239
                             a1.5 1.5 0 0 1-1.464-1.175L5.383 5.25Zm3.367
                             13.5a.75.75 0 1 1-1.5 0
                             .75.75 0 0 1 1.5 0Zm8.25
                             0a.75.75 0 1 1-1.5 0
                             .75.75 0 0 1 1.5 0Z"/>
                </svg>

                <span id="cart-count"
                      class="absolute -top-1.5 -right-2 min-w-[7px] h-[13px] text-[9px]
                             bg-gray-500 text-white text-xs
                             rounded-full px-2 scale-110">

                    {{ $cartCount ?? 0 }}

                </span>

            </a>

            @else

            <a href="/login" class="relative">
                🛒
            </a>

            @endauth

        </div>

    </div>

</nav>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-6 py-10">
    @yield('content')
</main>



</body>
</html>