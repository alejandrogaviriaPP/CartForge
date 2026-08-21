@extends('layouts.app')

@section('title', __('Profile'))

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="flex items-center gap-4 sm:gap-6 mb-8 sm:mb-10">

            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.4"
                    stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>

            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-semibold tracking-tight text-gray-900 truncate">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-gray-500 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="ml-auto shrink-0">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-full border border-gray-200 text-sm text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('Logout') }}</span>
                </button>
            </form>

        </div>

        <div class="space-y-6">

            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-black/5 p-4 sm:p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">{{ __('Language') }}</h2>
                <div class="rounded-xl border border-gray-200 overflow-hidden divide-y divide-gray-100">
                    <x-language-options />
                </div>
            </section>

        </div>

    </div>

@endsection
