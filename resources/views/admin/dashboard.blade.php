@extends('layouts.app')

@section('title', __('Admin panel'))

@section('content')

    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 mb-6 sm:mb-8">{{ __('Admin panel') }}</h1>

        <x-admin-nav />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-8">
            <x-stat-card label="{{ __('Products') }}" :value="$stats['products']">
                <x-slot name="slot">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M3 13.5h18M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="{{ __('Orders') }}" :value="$stats['orders']">
                <x-slot name="slot">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="{{ __('Revenue') }}" :value="'$' . number_format($stats['revenue'], 2)">
                <x-slot name="slot">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
                    </svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="{{ __('Pending orders') }}" :value="$stats['pending']">
                <x-slot name="slot">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0Z" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>

        <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl overflow-hidden">

            <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">{{ __('Latest orders') }}</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-green-600 hover:underline">{{ __('View all') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-4 sm:px-6 py-3">#</th>
                            <th class="px-4 py-3">{{ __('Customer') }}</th>
                            <th class="px-4 py-3">{{ __('Total') }}</th>
                            <th class="px-4 py-3">{{ __('Status') }}</th>
                            <th class="px-4 sm:px-6 py-3">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($latestOrders as $order)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-4 sm:px-6 py-3 font-semibold text-gray-900">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-green-600 transition-colors">#{{ $order->id }}</a>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->user?->name ?? '—' }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">${{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-3"><x-order-status :status="$order->status" /></td>
                                <td class="px-4 sm:px-6 py-3 text-gray-500 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach

                        @if ($latestOrders->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 sm:px-6 py-8 text-center text-gray-400">{{ __('No orders found.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection
