<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CartForge')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        window.i18n = @json($i18n);
    </script>
</head>

<body class="bg-gray-100 font-sans">

    <div id="toast" class="fixed bottom-6 right-6 z-[9999]
            bg-green-600 backdrop-blur-md text-white
            px-5 py-3 rounded-2xl shadow-xl
            opacity-0 translate-y-10 scale-90
            pointer-events-none
            transition-all duration-500 ease-out">
    </div>

    <div id="search-overlay" class="fixed inset-0 z-40 
            bg-white/80 backdrop-blur-[30px] 
            opacity-0 pointer-events-none 
            transition-opacity duration-200 ease-out">

        <div id="search-content" class="max-w-5xl mx-auto pt-16 sm:pt-24 px-4 sm:px-8 
                -translate-y-20 opacity-0 
                transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]">

            <form action="{{ route('products.index') }}" method="GET" class="mb-10 sm:mb-16">
                <div class="flex items-center gap-3 sm:gap-5 border-b border-gray-300 pb-4 sm:pb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input type="text" name="search" placeholder="{{ __('Search products') }}"
                        class="w-full bg-transparent text-2xl sm:text-4xl lg:text-5xl font-light tracking-tight placeholder:text-gray-300 focus:outline-none text-gray-900">

                    <button type="button" id="close-search"
                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-200/50 hover:bg-gray-200 transition flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-24">
                <div class="flex flex-col gap-6 sm:gap-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">{{ __('Quick Links') }}</p>
                    <div class="flex flex-col gap-4 sm:gap-5">
                        <a href="/products?search=apple"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Apple Products') }}</a>
                        <a href="/products?search=tv"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Smart TV Accessories') }}</a>
                        <a href="/products?search=headphones"
                            class="text-sm font-medium text-gray-600 hover:text-black transition">{{ __('Wireless Headphones') }}</a>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-6 sm:p-8 rounded-3xl border border-gray-100 h-fit">
                    <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('New Arrivals') }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ __('Check out our latest tech and lifestyle releases for this season.') }}</p>
                    <a href="/products" class="text-green-600 text-xs font-bold hover:underline">{{ __('See what\'s new →') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div id="categories-overlay" class="fixed inset-0 z-40 
            bg-white/80 backdrop-blur-[30px] 
            opacity-0 pointer-events-none 
            transition-opacity duration-200 ease-out">

        <div id="categories-content" class="max-w-5xl mx-auto pt-16 sm:pt-24 px-4 sm:px-8 
                -translate-y-20 opacity-0 
                transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]">

            <div class="flex items-center justify-between border-b border-gray-300 pb-4 sm:pb-5 mb-10 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-light tracking-tight text-gray-900">{{ __('Shop by Category') }}</h2>
                <button type="button" id="close-categories"
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-200/50 hover:bg-gray-200 transition flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-24">
                <div class="flex flex-col gap-6 sm:gap-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">{{ __('Our Collections') }}</p>
                    <div class="flex flex-col gap-4 sm:gap-5">
                        <a href="/products?category=tech"
                            class="text-xl sm:text-2xl font-medium text-gray-800 hover:text-green-600 transition">{{ __('Tech') }}</a>
                        <a href="/products?category=fashion"
                            class="text-xl sm:text-2xl font-medium text-gray-800 hover:text-green-600 transition">{{ __('Fashion') }}</a>
                        <a href="/products?category=home"
                            class="text-xl sm:text-2xl font-medium text-gray-800 hover:text-green-600 transition">{{ __('Home Goods') }}</a>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-6 sm:p-8 rounded-3xl border border-gray-100 h-fit">
                    <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('Curated Spaces') }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ __('Explore minimal hardware, premium garments, and essential products designed for daily utility.') }}</p>
                    <a href="/products" class="text-green-600 text-xs font-bold hover:underline">{{ __('View all categories →') }}</a>
                </div>
            </div>
        </div>
    </div>

    <nav class="glass-nav sticky top-0 z-50 text-[13px] tracking-tight text-gray-800">
        <div class="max-w-[1024px] xl:max-w-[1600px] mx-auto px-3 sm:px-6 h-14 flex items-center justify-between">

            <div class="flex justify-start shrink-0 -ml-1 sm:-ml-2">
                <a href="/"
                    class="text-xl sm:text-xl font-extrabold tracking-tight text-gray-900 hover:text-green-600 transition-colors">
                    CartForge
                </a>
            </div>

            <div class="hidden sm:flex justify-center items-center gap-10 text-gray-500 font-medium">
                <a href="/products" class="hover:text-gray-900 transition-colors">{{ __('Home') }}</a>
                <button id="categories-btn"
                    class="hover:text-gray-900 transition-colors focus:outline-none">{{ __('Categories') }}</button>
            </div>

            <div class="flex justify-end items-center gap-3 sm:gap-6">

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
                            class="absolute -top-1.5 -right-2 min-w-[14px] h-[14px] text-[9px] bg-green-600 text-white flex items-center justify-center rounded-full font-bold">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>

                    @if (auth()->user()?->is_admin)
                        <a href="{{ route('admin.dashboard') }}" title="Panel de administración"
                            class="hover:scale-105 active:scale-95 transition text-gray-700 hover:text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </a>
                    @endif

                    <x-profile-link class="ml-1 sm:ml-2 pl-2 sm:pl-4 border-l border-gray-200" />
                @else
                    <a href="/login" title="{{ __('Login') }}"
                        class="hover:scale-105 active:scale-95 transition text-gray-700 hover:text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                            stroke="currentColor" class="w-4 h-4 text-black/80">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386a1.5 1.5 0 0 1 1.415 1.022L5.383 5.25m0 0h13.867 a1.5 1.5 0 0 1 1.464 1.825l-1.5 7.5 a1.5 1.5 0 0 1-1.464 1.175H8.239 a1.5 1.5 0 0 1-1.464-1.175L5.383 5.25Zm3.367 13.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm8.25 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>

                    <x-language-switcher class="ml-1 sm:ml-2 pl-2 sm:pl-4 border-l border-gray-200" />
                @endauth

            </div>

        </div>
    </nav>

    <main class="max-w-7xl xl:max-w-[1600px] mx-auto px-3 sm:px-6 py-6 sm:py-10">
        @yield('content')
    </main>


</body>

</html>