<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }} - CartForge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

<div class="fixed top-4 right-4 z-50">
    <x-language-switcher class="bg-white/70 backdrop-blur rounded-lg p-1" />
</div>

<div class="min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl
                animate-[fadeIn_0.6s_ease]">

        <h2 class="text-2xl font-bold text-center mb-2">
            {{ __('Welcome back') }}
        </h2>

        <p class="text-sm text-gray-500 text-center mb-6">
            {{ __('Login to continue') }}
        </p>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-2xl text-xs text-gray-600">
            <p class="font-semibold text-gray-900 mb-1">{{ __('Testing the app?') }}</p>
            <p class="mb-3">{{ __('Use the guest credentials below to explore all features instantly without registering.') }}</p>

            <div class="flex flex-col gap-1 font-mono text-[11px] bg-white p-3 rounded-xl border border-gray-100 mb-3">
                <div><span class="text-gray-400">{{ __('Email') }}:</span> admin@cartforge.com</div>
                <div><span class="text-gray-400">{{ __('Password') }}:</span> password123</div>
            </div>

            <button type="button"
                    onclick="fillDemoCredentials()"
                    class="w-full py-2 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition active:scale-95 text-center">
                {{ __('Autofill & Login') }}
            </button>
        </div>

        <a href="/auth/google"
           class="flex items-center justify-center gap-2 w-full border rounded-lg py-2 hover:bg-gray-100 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
            <span>{{ __('Continue with Google') }}</span>
        </a>

        <div class="flex items-center my-4">
            <div class="flex-grow h-px bg-gray-300"></div>
            <span class="px-3 text-gray-400 text-sm">{{ __('or') }}</span>
            <div class="flex-grow h-px bg-gray-300"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <input type="email" name="email" placeholder="{{ __('Email') }}"
                class="w-full mt-2 p-2 border rounded-lg focus:ring-2 focus:ring-black">

            <input id="password" type="password" name="password" placeholder="{{ __('Password') }}"
                class="w-full mt-3 p-2 border rounded-lg focus:ring-2 focus:ring-black">

            <button type="button" onclick="togglePassword()"
                class="text-xs text-gray-500 mt-1">
                {{ __('Show password') }}
            </button>

            <button
                class="w-full mt-6 bg-black text-white py-2 rounded-lg
                       hover:bg-gray-800 transition active:scale-95 hover:shadow-lg">
                {{ __('Login') }}
            </button>

        </form>

        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-black">
                {{ __("Don't have an account?") }}
            </a>
        </div>

    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}

function fillDemoCredentials() {
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const loginForm = emailInput.closest('form');

    if (emailInput && passwordInput) {
        emailInput.value = 'admin@cartforge.com';
        passwordInput.value = 'password123';
        loginForm.submit();
    }
}
</script>

</body>
</html>