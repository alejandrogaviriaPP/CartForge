@extends('layouts.app')

@section('title', __('Orders') . ' · ' . __('Admin panel'))

@section('content')

    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 mb-6 sm:mb-8">{{ __('Orders') }}</h1>

        <x-admin-nav />

        <x-flash />

        <form action="{{ route('admin.orders.index') }}" method="GET"
            class="flex flex-col sm:flex-row gap-3 mb-6">
            <select name="status"
                class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-green-500 sm:w-48"
                onchange="this.form.submit()">
                <option value="">{{ __('All statuses') }}</option>
                @foreach (\App\Models\Order::STATUSES as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ __(ucfirst($status)) }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by customer or reference') }}"
                class="flex-1 bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl px-4 py-3 text-sm placeholder:text-gray-400 focus:outline-none focus:border-green-500">
        </form>

        <div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-4 sm:px-6 py-3">#</th>
                            <th class="px-4 py-3">{{ __('Customer') }}</th>
                            <th class="px-4 py-3">{{ __('Items') }}</th>
                            <th class="px-4 py-3">{{ __('Total') }}</th>
                            <th class="px-4 py-3">{{ __('Payment') }}</th>
                            <th class="px-4 py-3">{{ __('Status') }}</th>
                            <th class="px-4 py-3">{{ __('Date') }}</th>
                            <th class="px-4 sm:px-6 py-3 text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-4 sm:px-6 py-3 font-semibold text-gray-900">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-green-600 transition-colors">#{{ $order->id }}</a>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="font-medium text-gray-900">{{ $order->user?->name ?? '—' }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->user?->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->items_count }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap">${{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ ucfirst($order->payment_method) }}</td>
                                <td class="px-4 py-3"><x-order-status :status="$order->status" /></td>
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 sm:px-6 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status"
                                                class="border-gray-200 bg-gray-50 rounded-lg text-xs py-1.5 px-2 focus:outline-none focus:border-green-500"
                                                onchange="this.form.requestSubmit()">
                                                @foreach (\App\Models\Order::STATUSES as $status)
                                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ __(ucfirst($status)) }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="8" class="px-4 sm:px-6 py-8 text-center text-gray-400">{{ __('No orders found.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>

        </div>

    </div>

@endsection
