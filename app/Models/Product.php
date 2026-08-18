<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'gallery',
        'category',
        'brand',
    ];

    protected $casts = [
        'gallery' => 'array',
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

    public function getGalleryImagesAttribute(): array
    {
        $images = $this->gallery ?? [];

        if (empty($images)) {
            return [$this->image];
        }

        return array_values(array_unique(array_merge([$this->image], $images)));
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->ratings()->avg('rating'), 1);
    }

    public function getRatingsCountAttribute(): int
    {
        return $this->ratings()->count();
    }
}
