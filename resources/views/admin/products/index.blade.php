@extends('layouts.app')

@section('title', __('Products') . ' · ' . __('Admin panel'))

@section('content')

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">{{ __('Products') }}</h1>
            <a href="{{ route('admin.products.create') }}"
                class="bg-green-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700 transition active:scale-95 text-center">
                {{ __('New product') }}
            </a>
        </div>

        <x-admin-nav />

        <x-flash />

        <form action="{{ route('admin.products.index') }}" method="GET" class="mb-6">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by name, brand or category') }}"
                    class="w-full bg-white/70 backdrop-blur-md border border-white/70 shadow-sm rounded-2xl pl-11 pr-4 py-3 text-sm placeholder:text-gray-400 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition">
            </div>
        </form>

        <div class="bg-white/70 backdrop-blur-xl border border-white/70 shadow-[0_2px_16px_rgba(0,0,0,0.04)] rounded-3xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-4 sm:px-6 py-3">{{ __('Image') }}</th>
                            <th class="px-4 py-3">{{ __('Name') }}</th>
                            <th class="px-4 py-3">{{ __('Category') }}</th>
                            <th class="px-4 py-3">{{ __('Price') }}</th>
                            <th class="px-4 py-3">{{ __('Stock') }}</th>
                            <th class="px-4 sm:px-6 py-3 text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-4 sm:px-6 py-3">
                                    <div class="w-11 h-11 rounded-xl bg-white border border-gray-100 flex items-center justify-center shadow-sm">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="w-9 h-9 object-contain">
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 max-w-[220px] truncate">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-green-600 transition-colors" target="_blank">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($product->category)
                                        <span class="inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full border
                                            {{ $product->category === 'tech' ? 'bg-blue-50/80 text-blue-600 border-blue-100' : ($product->category === 'fashion' ? 'bg-pink-50/80 text-pink-600 border-pink-100' : 'bg-amber-50/80 text-amber-600 border-amber-100') }}">
                                            {{ $product->category === 'home' ? __('Home Goods') : __(ucfirst($product->category)) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.products.stock', $product) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="delta" value="-1" {{ $product->stock === 0 ? 'disabled' : '' }}
                                                class="w-6 h-6 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold hover:bg-gray-200 transition disabled:opacity-30">−</button>
                                        </form>

                                        @if ($product->stock === 0)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50/80 border border-red-100 px-2.5 py-1 rounded-full whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                {{ __('Out of stock') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-sm font-bold whitespace-nowrap {{ $product->stock <= 3 ? 'text-amber-600' : 'text-gray-900' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $product->stock <= 3 ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                                                {{ $product->stock }}
                                                @if ($product->stock <= 3)
                                                    <span class="text-[10px] font-bold uppercase tracking-wide text-amber-500">{{ __('Low stock') }}</span>
                                                @endif
                                            </span>
                                        @endif

                                        <form action="{{ route('admin.products.stock', $product) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="delta" value="1"
                                                class="w-6 h-6 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold hover:bg-gray-200 transition">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                            {{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('{{ __('Delete this product?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-600 hover:bg-red-200 transition">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($products->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-gray-400">{{ __('No products found.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>

        </div>

    </div>

@endsection
