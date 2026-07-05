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

    /**
     * Return the product name in the active locale. Falls back to the
     * English base column when no Spanish translation exists.
     */
    public function getNameAttribute($value)
    {
        if (app()->isLocale('es') && ! empty($this->attributes['name_es'])) {
            return $this->attributes['name_es'];
        }

        return $value;
    }

    /**
     * Return the product description in the active locale.
     */
    public function getDescriptionAttribute($value)
    {
        if (app()->isLocale('es') && ! empty($this->attributes['description_es'])) {
            return $this->attributes['description_es'];
        }

        return $value;
    }
}
