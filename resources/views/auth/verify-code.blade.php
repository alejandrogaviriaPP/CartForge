<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('login_code.page_title') }} - CartForge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

<div class="fixed top-4 right-4 z-50">
    <x-language-switcher class="bg-white/70 backdrop-blur rounded-lg p-1" />
</div>

<div class="min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl
                animate-[fadeIn_0.6s_ease]">

        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-blue-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-7 h-7 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2">{{ __('login_code.page_title') }}</h2>
            <p class="text-sm text-gray-500">{{ __('login_code.page_subheading', ['email' => $email]) }}</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.verify.check') }}">
            @csrf

            <input type="text"
                name="code"
                inputmode="numeric"
                autocomplete="one-time-code"
                maxlength="6"
                pattern="[0-9]{6}"
                placeholder="{{ __('login_code.code_placeholder') }}"
                value="{{ old('code') }}"
                autofocus
                class="w-full text-center tracking-[0.5em] text-2xl font-bold p-3 border rounded-lg focus:ring-2 focus:ring-black {{ $errors->has('code') ? 'border-red-400' : '' }}">

            @error('code')
                <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
            @enderror

            <button class="w-full mt-6 bg-black text-white py-2 rounded-lg
                           hover:bg-gray-800 transition active:scale-95 hover:shadow-lg">
                {{ __('login_code.confirm_btn') }}
            </button>
        </form>

        <div class="flex items-center justify-between mt-5 text-sm">
            <form method="POST" action="{{ route('login.verify.resend') }}">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline">
                    {{ __('login_code.resend') }}
                </button>
            </form>

            <a href="{{ route('login') }}" class="text-gray-500 hover:text-black">
                {{ __('login_code.back_to_login') }}
            </a>
        </div>

    </div>

</div>

</body>
</html>
