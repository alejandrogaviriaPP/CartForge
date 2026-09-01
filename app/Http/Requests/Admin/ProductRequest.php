<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $isUpdate = $this->route('product') !== null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'name_es' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'description_es' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'old_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'image' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
        ];
    }
}
