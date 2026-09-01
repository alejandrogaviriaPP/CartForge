<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public const STATUSES = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

    public const CANCELLABLE_STATUSES = ['pending', 'paid'];

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

    public function cancellable(): bool
    {
        return in_array($this->status, self::CANCELLABLE_STATUSES, true);
    }

    public function cancel(): bool
    {
        if (! $this->cancellable()) {
            return false;
        }

        return (bool) DB::transaction(function () {
            $this->items()->with('product:id,stock')->get()->each(function ($item) {
                $item->product?->increment('stock', $item->quantity);
            });

            return $this->update(['status' => 'cancelled']);
        });
    }

    public static function markDelivered(): int
    {
        return static::query()
            ->where('status', 'shipped')
            ->where('delivery_max', '<', today())
            ->update(['status' => 'delivered']);
    }

    public static function expireUnpaid(): int
    {
        $cancelled = 0;

        static::query()
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subDay())
            ->get()
            ->each(function (Order $order) use (&$cancelled) {
                $cancelled += $order->cancel() ? 1 : 0;
            });

        return $cancelled;
    }
}
