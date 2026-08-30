<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'country', 'payment_method', 'status', 'payment_reference', 'payment_url', 'delivery_min', 'delivery_max'];

    protected function casts(): array
    {
        return [
            'delivery_min' => 'date',
            'delivery_max' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
