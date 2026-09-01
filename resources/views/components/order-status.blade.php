@props(['status'])

@php
    $styles = [
        'pending' => 'bg-amber-100 text-amber-700',
        'paid' => 'bg-green-100 text-green-700',
        'shipped' => 'bg-sky-100 text-sky-700',
        'delivered' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-red-100 text-red-700',
    ];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap {{ $styles[$status] ?? 'bg-gray-100 text-gray-600' }}">
    {{ __(ucfirst($status)) }}
</span>
