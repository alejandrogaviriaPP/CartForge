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
