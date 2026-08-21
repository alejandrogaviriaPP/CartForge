<div {{ $attributes->merge(['class' => 'relative group']) }}>
    <button type="button" aria-label="{{ __('Language') }}"
            class="flex items-center gap-1 py-1 text-gray-700 hover:text-black transition hover:scale-105 active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m-9 9h18" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="absolute right-0 top-full z-50 w-40 pt-2 origin-top-right
                opacity-0 invisible pointer-events-none translate-y-1
                transition-all duration-150
                group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto group-hover:translate-y-0">
        <div class="bg-white rounded-xl shadow-lg ring-1 ring-black/5 py-1 overflow-hidden">
            <x-language-options />
        </div>
    </div>
</div>
