<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    const ORDER_TYPE_STORE = 'store';
    const ORDER_TYPE_ASSET = 'asset';

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_COMPLETED = 'completed';

    protected $fillable = [
        'user_id', 'order_number', 'order_type', 'status', 'payment_status',
        'total_amount', 'total_coins_used', 'order_data', 'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_data' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            if (empty($model->order_number)) {
                $model->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isStoreOrder()
    {
        return $this->order_type === self::ORDER_TYPE_STORE;
    }

    public function isAssetOrder()
    {
        return $this->order_type === self::ORDER_TYPE_ASSET;
    }

    public function getTypeDisplayAttribute()
    {
        return match($this->order_type) {
            self::ORDER_TYPE_STORE => 'Store Purchase',
            self::ORDER_TYPE_ASSET => 'Asset Purchase',
            default => 'Order'
        };
    }

    public function markAsShipped()
    {
        $this->update(['status' => self::STATUS_SHIPPED]);
    }

    public function markAsDelivered()
    {
        $this->update(['status' => self::STATUS_DELIVERED]);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }
}