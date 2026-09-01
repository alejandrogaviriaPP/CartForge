@props(['label', 'value'])

<div class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-6 flex items-center gap-4">
    @isset($slot)
        <div class="w-11 h-11 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
            {{ $slot }}
        </div>
    @endisset
    <div class="min-w-0">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em]">{{ $label }}</p>
        <p class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 mt-1 truncate">{{ $value }}</p>
    </div>
</div>
