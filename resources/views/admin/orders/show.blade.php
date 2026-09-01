@extends('layouts.app')

@section('title', __('Order') . ' #' . $order->id . ' · ' . __('Admin panel'))

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 sm:mb-8">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">{{ __('Order') }} #{{ $order->id }}</h1>
                <x-order-status :status="$order->status" />
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-black transition-colors">{{ __('Back') }}</a>
        </div>

        <x-admin-nav />

        <x-flash />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">

            <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] mb-3">{{ __('Customer') }}</p>
                <p class="font-semibold text-gray-900">{{ $order->user?->name ?? '—' }}</p>
                <p class="text-sm text-gray-600">{{ $order->user?->email }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $order->country }}</p>
            </div>

            <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] mb-3">{{ __('Payment') }}</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                @if ($order->payment_reference)
                    <p class="text-sm text-gray-600">{{ __('Reference') }}: {{ $order->payment_reference }}</p>
                @endif
                @if ($order->payment_url)
                    <a href="{{ $order->payment_url }}" target="_blank" rel="noopener"
                        class="inline-block mt-2 text-xs font-bold text-green-600 hover:underline">{{ __('View transaction') }}</a>
                @endif
            </div>

            <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] mb-3">{{ __('Estimated delivery') }}</p>
                <p class="font-semibold text-gray-900">
                    {{ $order->delivery_min?->locale(app()->getLocale())->translatedFormat('j M') }} — {{ $order->delivery_max?->locale(app()->getLocale())->translatedFormat('j M, Y') }}
                </p>
                <p class="text-sm text-gray-600 mt-1">{{ __('Created on') }} {{ $order->created_at->format('d/m/Y') }}</p>
            </div>

        </div>

        <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-6 mb-6">
            <form action="{{ route('admin.orders.status', $order) }}" method="POST"
                class="flex flex-col sm:flex-row sm:items-end gap-3">
                @csrf
                @method('PATCH')
                <div class="flex-1">
                    <x-input-label for="status" value="{{ __('Order status') }}" />
                    <select id="status" name="status"
                        class="w-full mt-1.5 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                        @foreach (\App\Models\Order::STATUSES as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ __(ucfirst($status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700 transition active:scale-95">
                    {{ __('Update status') }}
                </button>
            </form>
        </div>

        <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl overflow-hidden">

            <div class="px-4 sm:px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">{{ __('Items') }}</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-4 sm:px-6 py-3">{{ __('Product') }}</th>
                            <th class="px-4 py-3">{{ __('Price') }}</th>
                            <th class="px-4 py-3">{{ __('Quantity') }}</th>
                            <th class="px-4 sm:px-6 py-3 text-right">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-4 sm:px-6 py-3 font-medium text-gray-900">{{ $item->name }}</td>
                                <td class="px-4 py-3 text-gray-600">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-4 sm:px-6 py-3 text-right font-semibold text-gray-900">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-200">
                            <td colspan="3" class="px-4 sm:px-6 py-4 text-right text-gray-500">{{ __('Total') }}</td>
                            <td class="px-4 sm:px-6 py-4 text-right text-lg font-semibold text-gray-900">
                                ${{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>

@endsection
