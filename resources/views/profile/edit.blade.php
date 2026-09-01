@extends('layouts.app')

@section('title', __('Profile'))

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="flex items-center gap-4 sm:gap-6 mb-8 sm:mb-10">

            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.4"
                    stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>

            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-semibold tracking-tight text-gray-900 truncate">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-gray-500 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="ml-auto shrink-0">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-full border border-gray-200 text-sm text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('Logout') }}</span>
                </button>
            </form>

        </div>

        <div class="space-y-6">

            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-black/5 p-4 sm:p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">{{ __('Personal information') }}</h2>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-3">
                    @csrf
                    @method('PATCH')

                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ __('Name') }}"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-600">

                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="{{ __('Email') }}"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-600">

                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="{{ __('Phone') }}"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-600">

                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        placeholder="{{ __('Address') }}"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-600">

                    <x-country-select :selected="old('country', $user->country)" />

                    @if (session('status'))
                        <p class="text-xs font-semibold text-green-600">{{ __('Saved.') }}</p>
                    @endif

                    <button type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm hover:-translate-y-0.5 active:scale-95 transition">
                        {{ __('Save') }}
                    </button>
                </form>
            </section>

            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-black/5 p-4 sm:p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">{{ __('Language') }}</h2>
                <div class="rounded-xl border border-gray-200 overflow-hidden divide-y divide-gray-100">
                    <x-language-options />
                </div>
            </section>

            <section
                class="bg-white rounded-2xl shadow-sm ring-1 ring-black/5 p-4 sm:p-6 flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <h2 class="text-base font-semibold text-gray-900">{{ __('Wishlist') }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $wishlistCount }} {{ __('products saved') }}
                    </p>
                </div>
                <a href="{{ route('wishlist.index') }}"
                    class="shrink-0 flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:-translate-y-0.5 active:scale-95 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"
                        fill="none" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    {{ __('View products added') }}
                </a>
            </section>

            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-black/5 p-4 sm:p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">{{ __('My orders') }}</h2>

                @forelse ($orders as $order)
                    <div class="{{ ! $loop->first ? 'border-t border-gray-100' : '' }}">
                        <div
                            class="order-toggle flex items-center justify-between gap-3 py-3 -mx-2 px-2 rounded-lg cursor-pointer select-none hover:bg-gray-50 transition">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $order->created_at->locale(app()->getLocale())->translatedFormat('d M Y') }} ·
                                    {{ $order->items->sum('quantity') }} {{ __('items') }} ·
                                    {{ $order->items->first()->name }}@if ($order->items->count() > 1)+{{ $order->items->count() - 1 }}@endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <div class="text-right">
                                    <x-order-status :status="$order->status" />
                                    @if (! in_array($order->status, ['delivered', 'cancelled']))
                                        <p class="text-xs font-semibold text-gray-900 mt-0.5">
                                            {{ __('Arrives between :min and :max', [
                                                'min' => $order->delivery_min->locale(app()->getLocale())->translatedFormat('j M'),
                                                'max' => $order->delivery_max->locale(app()->getLocale())->translatedFormat('j M'),
                                            ]) }}
                                        </p>
                                    @endif
                                    <p class="text-[11px] text-gray-400">#{{ $order->id }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.7" stroke="currentColor"
                                    class="order-chevron w-4 h-4 text-gray-400 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>

                        <div class="order-details hidden pb-4">
                            <div class="rounded-xl bg-gray-50 p-3 sm:p-4 space-y-2">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center justify-between gap-3 text-sm">
                                        <span class="text-gray-700 min-w-0 truncate">
                                            {{ $item->name }}
                                            <span class="text-gray-400">×{{ $item->quantity }}</span>
                                        </span>
                                        <span class="text-gray-900 font-medium shrink-0">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </span>
                                    </div>
                                @endforeach

                                <div
                                    class="border-t border-gray-200 pt-2 flex items-center justify-between text-sm font-semibold">
                                    <span>{{ __('Total') }}</span>
                                    <span>${{ number_format($order->total, 2) }}</span>
                                </div>

                                <p class="text-xs text-gray-500 pt-1">
                                    {{ __('Shipping to') }} {{ $order->country }} · #{{ $order->id }}
                                </p>

                                @if ($order->cancellable())
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                        onsubmit="return confirm('{{ __('Cancel this order?') }}')"
                                        class="pt-2">
                                        @csrf
                                        <button type="submit"
                                            class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-semibold bg-red-50 text-red-600 hover:bg-red-100 transition">
                                            {{ __('Cancel order') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">{{ __('No orders yet') }}</p>
                @endforelse
            </section>

        </div>

    </div>

@endsection
