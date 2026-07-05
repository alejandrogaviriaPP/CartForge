@php
    $current = app()->getLocale();

    $languages = [
        'en' => [
            'label' => 'English',
            'flag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 8" class="block w-5 h-3.5"><rect width="12" height="8" fill="#ffffff"/><rect width="12" height="0.615" y="0" fill="#B22234"/><rect width="12" height="0.615" y="1.231" fill="#B22234"/><rect width="12" height="0.615" y="2.462" fill="#B22234"/><rect width="12" height="0.615" y="3.692" fill="#B22234"/><rect width="12" height="0.615" y="4.923" fill="#B22234"/><rect width="12" height="0.615" y="6.154" fill="#B22234"/><rect width="12" height="0.615" y="7.385" fill="#B22234"/><rect width="4.8" height="4.308" fill="#3C3B6E"/></svg>',
        ],
        'es' => [
            'label' => 'Español',
            'flag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 6" class="block w-5 h-3.5"><rect width="9" height="6" fill="#AA151B"/><rect width="9" height="3" y="1.5" fill="#F1BF00"/></svg>',
        ],
    ];
@endphp

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
            @foreach ($languages as $code => $lang)
                @php $active = $current === $code; @endphp
                <a href="{{ route('language.switch', $code) }}"
                   class="flex items-center gap-2.5 px-3 py-2 text-sm transition {{ $active ? 'bg-gray-50 text-black font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-black' }}">
                    <span class="inline-flex rounded-sm overflow-hidden ring-1 ring-black/10">{!! $lang['flag'] !!}</span>
                    <span>{{ $lang['label'] }}</span>
                    @if ($active)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-auto w-4 h-4 text-blue-600">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
