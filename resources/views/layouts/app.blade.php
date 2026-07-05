<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CartForge')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $i18n = [
            'login_required_title' => __('Login required'),
            'login_required_text' => __('You need to login to add items to your cart'),
            'go_to_login' => __('Go to login'),
            'added' => __('Product added to cart'),
            'removed' => __('Product removed from cart'),
            'total_label' => __('Total:'),
            'empty_cart_title' => __('Empty Cart'),
            'empty_cart_text' => __('Your shopping cart is currently empty.'),
            'checkout_confirm_title' => __('Are you sure?'),
            'checkout_confirm_text' => __('Do you want to complete this purchase?'),
            'yes_checkout' => __('Yes, checkout!'),
            'cancel' => __('Cancel'),
            'order_placed_title' => __('Order Placed!'),
            'order_placed_text' => __('Your order has been processed successfully.'),
            'shopping_cart' => __('Shopping Cart'),
            'cart_empty_thanks' => __('Your cart is now empty. Thank you for your purchase!'),
            'back_to_products' => __('Back to Products'),
            'error_title' => __('Error'),
            'error_text' => __('Something went wrong with the transaction.'),
        ];
    @endphp

    <script>
        window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        window.i18n = @json($i18n);
    </script>
</head>

<body class="bg-gray-100 font-sans">

    <div id="toast" class="fixed bottom-6 right-6 z-[9999]
            bg-blue-500/80 backdrop-blur-md text-white
            px-5 py-3 rounded-2xl shadow-xl
            opacity-0 translate-y-10 scale-90
            pointer-events-none
            transition-all duration-500 ease-out">
    </div>

    <div id="search-overlay" class="fixed inset-0 z-40 
            bg-white/80 backdrop-blur-[30px] 
            opacity-0 pointer-events-none 
            transition-opacity duration-200 ease-out">

        <div id="search-content" class="max-w-5xl mx-auto pt-24 px-8 
                -translate-y-20 opacity-0 
                transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]">

            <form action="{{ route('products.index') }}" method="GET" class="mb-16">
                <div class="flex items-center gap-5 border-b border-gray-300 pb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input type="text" name="search" placeholder="{{ __('Search products') }}"
                        class="w-full bg-transparent text-5xl font-light tracking-tight placeholder:text-gray-300 focus:outline-none text-gray-900">

                    <button type="button" id="close-search"
                        class="w-12 h-12 rounded-full bg-gray-200/50 hover:bg-gray-200 transition flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-24">
                <div class="flex flex-col gap-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">{{ __('Quick Links') }}</p>
                    <div class="flex flex-col gap-5">
                        <a href="/products?search=apple"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Apple Products') }}</a>
                        <a href="/products?search=tv"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Smart TV Accessories') }}</a>
                        <a href="/products?search=headphones"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Wireless Headphones') }}</a>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 h-fit">
                    <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('New Arrivals') }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ __('Check out our latest tech and lifestyle releases for this season.') }}</p>
                    <a href="/products" class="text-blue-600 text-xs font-bold hover:underline">{{ __('See what\'s new →') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div id="categories-overlay" class="fixed inset-0 z-40 
            bg-white/80 backdrop-blur-[30px] 
            opacity-0 pointer-events-none 
            transition-opacity duration-200 ease-out">

        <div id="categories-content" class="max-w-5xl mx-auto pt-24 px-8 
                -translate-y-20 opacity-0 
                transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]">

            <div class="flex items-center justify-between border-b border-gray-300 pb-5 mb-16">
                <h2 class="text-4xl font-light tracking-tight text-gray-900">{{ __('Shop by Category') }}</h2>
                <button type="button" id="close-categories"
                    class="w-12 h-12 rounded-full bg-gray-200/50 hover:bg-gray-200 transition flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-24">
                <div class="flex flex-col gap-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">{{ __('Our Collections') }}</p>
                    <div class="flex flex-col gap-5">
                        <a href="/products?category=tech"
                            class="text-2xl font-medium text-gray-800 hover:text-blue-600 transition">{{ __('Tech') }}</a>
                        <a href="/products?category=fashion"
                            class="text-2xl font-medium text-gray-800 hover:text-blue-600 transition">{{ __('Fashion') }}</a>
                        <a href="/products?category=home"
                            class="text-2xl font-medium text-gray-800 hover:text-blue-600 transition">{{ __('Home Goods') }}</a>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 h-fit">
                    <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('Curated Spaces') }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ __('Explore minimal hardware, premium garments, and essential products designed for daily utility.') }}</p>
                    <a href="/products" class="text-blue-600 text-xs font-bold hover:underline">{{ __('View all categories →') }}</a>
                </div>
            </div>
        </div>
    </div>

    <nav
        class="bg-white/70 backdrop-blur-md border-b border-gray-200/80 sticky top-0 z-50 text-[13px] tracking-tighter font-normal text-gray-800">
        <div class="max-w-[1024px] mx-auto px-6 h-12 flex items-center justify-between">

            <div class="w-1/4 flex justify-start">
                <a href=""
                    class="text-sm font-semibold tracking-tight text-black hover:opacity-70 transition-opacity">
                    CartForge
                </a>
            </div>

            <div class="w-2/4 flex justify-center items-center gap-10 text-gray-500 font-medium">
                <a href="/products" class="hover:text-black transition-colors">{{ __('Home') }}</a>
                <button id="categories-btn"
                    class="hover:text-black transition-colors focus:outline-none">{{ __('Categories') }}</button>
            </div>

            <div class="w-1/4 flex justify-end items-center gap-6">

                <button id="search-btn"
                    class="text-gray-700 hover:text-black transition hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.85-5.15 a7 7 0 1 1-14 0 a7 7 0 0 1 14 0Z" />
                    </svg>
                </button>

                @auth
                    <a href="{{ route('cart.index') }}" class="relative hover:scale-105 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                            stroke="currentColor" class="w-4 h-4 text-black/80">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386a1.5 1.5 0 0 1 1.415 1.022L5.383 5.25m0 0h13.867 a1.5 1.5 0 0 1 1.464 1.825l-1.5 7.5 a1.5 1.5 0 0 1-1.464 1.175H8.239 a1.5 1.5 0 0 1-1.464-1.175L5.383 5.25Zm3.367 13.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm8.25 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span id="cart-count"
                            class="absolute -top-1.5 -right-2 min-w-[14px] h-[14px] text-[9px] bg-gray-900 text-white flex items-center justify-center rounded-full font-bold">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                        @csrf
                        <button type="submit" title="{{ __('Logout') }}"
                            class="hover:scale-105 active:scale-95 transition text-gray-700 hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="/login" title="{{ __('Login') }}"
                        class="hover:scale-105 active:scale-95 transition text-gray-700 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                            stroke="currentColor" class="w-4 h-4 text-black/80">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386a1.5 1.5 0 0 1 1.415 1.022L5.383 5.25m0 0h13.867 a1.5 1.5 0 0 1 1.464 1.825l-1.5 7.5 a1.5 1.5 0 0 1-1.464 1.175H8.239 a1.5 1.5 0 0 1-1.464-1.175L5.383 5.25Zm3.367 13.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm8.25 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>
                @endauth

                <x-language-switcher class="ml-2 pl-4 border-l border-gray-200" />

            </div>

        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>


</body>

</html>