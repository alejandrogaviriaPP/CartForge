<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'name_es',
        'description',
        'description_es',
        'price',
        'old_price',
        'image',
        'category',
        'brand',
    ];

    public function getNameAttribute($value)
    {
        if (app()->isLocale('es') && ! empty($this->attributes['name_es'])) {
            return $this->attributes['name_es'];
        }

        return $value;
    }

    public function getDescriptionAttribute($value)
    {
        if (app()->isLocale('es') && ! empty($this->attributes['description_es'])) {
            return $this->attributes['description_es'];
        }

        return $value;
    }
}
