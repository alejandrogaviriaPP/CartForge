@extends('layouts.app')

@section('title', $product->exists ? __('Edit product') . ' · ' . __('Admin panel') : __('New product') . ' · ' . __('Admin panel'))

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">
                {{ $product->exists ? __('Edit product') : __('New product') }}
            </h1>
            <a href="{{ route('admin.products.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-black transition-colors">{{ __('Back') }}</a>
        </div>

        <x-admin-nav />

        <x-flash />

        @if ($errors->any())
            <div class="mb-6 bg-red-50/80 backdrop-blur-md border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-medium">
                {{ __('Please review the highlighted fields.') }}
            </div>
        @endif

        <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
            method="POST" enctype="multipart/form-data"
            class="bg-white/70 backdrop-blur-md border border-gray-200/80 rounded-2xl p-4 sm:p-8">

            @csrf
            @if ($product->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <x-input-label for="name" value="{{ __('Name (EN)') }} *" />
                    <x-text-input id="name" name="name" type="text" value="{{ old('name', $product->name) }}"
                        class="w-full mt-1.5" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="name_es" value="{{ __('Name (ES)') }}" />
                    <x-text-input id="name_es" name="name_es" type="text" value="{{ old('name_es', $product->name_es) }}"
                        class="w-full mt-1.5" />
                    <x-input-error :messages="$errors->get('name_es')" class="mt-1.5" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <x-input-label for="description" value="{{ __('Description (EN)') }} *" />
                    <textarea id="description" name="description" rows="4" required
                        class="w-full mt-1.5 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="description_es" value="{{ __('Description (ES)') }}" />
                    <textarea id="description_es" name="description_es" rows="4"
                        class="w-full mt-1.5 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">{{ old('description_es', $product->description_es) }}</textarea>
                    <x-input-error :messages="$errors->get('description_es')" class="mt-1.5" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">
                <div>
                    <x-input-label for="price" value="{{ __('Price') }} *" />
                    <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                        value="{{ old('price', $product->price) }}" class="w-full mt-1.5" required />
                    <x-input-error :messages="$errors->get('price')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="old_price" value="{{ __('Previous price') }}" />
                    <x-text-input id="old_price" name="old_price" type="number" step="0.01" min="0"
                        value="{{ old('old_price', $product->old_price) }}" class="w-full mt-1.5" />
                    <x-input-error :messages="$errors->get('old_price')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="stock" value="{{ __('Stock') }}" />
                    <x-text-input id="stock" name="stock" type="number" min="0"
                        value="{{ old('stock', $product->stock ?? 0) }}" class="w-full mt-1.5" required />
                    <x-input-error :messages="$errors->get('stock')" class="mt-1.5" />
                </div>
            </div>

            <div class="mb-5">
                @if ($product->exists)
                    <x-input-label for="image" value="{{ __('Main image') }}" />
                @else
                    <x-input-label for="image" value="{{ __('Main image') }} *" />
                @endif
                <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp"
                    {{ $product->exists ? '' : 'required' }}
                    class="w-full mt-1.5 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition" />
                <x-input-error :messages="$errors->get('image')" class="mt-1.5" />
                @if ($product->image)
                    <div class="flex items-center gap-2 mt-2">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="w-14 h-14 object-contain rounded-xl bg-white border border-gray-100">
                        <span class="text-xs text-gray-400">{{ __('Current image') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <x-input-label for="gallery" value="{{ __('Gallery images') }}" />
                <input id="gallery" name="gallery[]" type="file" accept="image/png,image/jpeg,image/webp" multiple
                    class="w-full mt-1.5 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition" />
                <x-input-error :messages="$errors->get('gallery.*')" class="mt-1.5" />
                @if ($product->gallery)
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($product->gallery as $galleryImage)
                            <img src="{{ asset($galleryImage) }}" alt="{{ $product->name }}"
                                class="w-12 h-12 object-contain rounded-lg bg-white border border-gray-100">
                        @endforeach
                        <span class="text-xs text-gray-400 self-center">{{ __('Uploading new images replaces the current gallery') }}</span>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                <div>
                    <x-input-label for="category" value="{{ __('Category') }}" />
                    <x-text-input id="category" name="category" type="text" value="{{ old('category', $product->category) }}"
                        placeholder="tech / fashion / home" class="w-full mt-1.5" />
                    <x-input-error :messages="$errors->get('category')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="brand" value="{{ __('Brand') }}" />
                    <x-text-input id="brand" name="brand" type="text" value="{{ old('brand', $product->brand) }}"
                        class="w-full mt-1.5" />
                    <x-input-error :messages="$errors->get('brand')" class="mt-1.5" />
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700 transition active:scale-95">
                    {{ $product->exists ? __('Save changes') : __('Create product') }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    {{ __('Cancel') }}
                </a>
            </div>

        </form>

    </div>

@endsection
