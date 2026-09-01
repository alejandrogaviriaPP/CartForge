@php
    $links = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => __('Dashboard')],
        ['route' => 'admin.products.index', 'match' => 'admin.products.*', 'label' => __('Products')],
        ['route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'label' => __('Orders')],
    ];
@endphp

<div class="flex items-center gap-5 sm:gap-8 mb-6 sm:mb-10 border-b border-gray-200/80 pb-3 overflow-x-auto">
    @foreach ($links as $link)
        <a href="{{ route($link['route']) }}"
            class="text-sm font-medium whitespace-nowrap transition-colors {{ request()->routeIs($link['match']) ? 'text-green-600 border-b-2 border-green-600 pb-3 -mb-3' : 'text-gray-500 hover:text-black' }}">
            {{ $link['label'] }}
        </a>
    @endforeach
</div>
