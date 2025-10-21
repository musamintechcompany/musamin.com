<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class CoinTransaction extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hashid',
        'user_id',
        'package_id',
        'package_name',
        'amount',
        'base_coins',
        'bonus_coins',
        'total_coins',
        'payment_type',
        'payment_method',
        'payment_credentials',
        'proofs',
        'notes',
        'status',
        'decline_reason',
        'staff_comments',
        'completed_at',
        'ip_address',
        'user_agent',
        'time_taken'
    ];

    protected $casts = [
        'payment_credentials' => 'array',
        'proofs' => 'array',
        'completed_at' => 'datetime',
        'amount' => 'decimal:2',
        'base_coins' => 'integer',
        'bonus_coins' => 'integer',
        'total_coins' => 'integer',
        'time_taken' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            if (empty($model->hashid)) {
                $model->hashid = $model->generateHashid();
            }
        });
    }

    public function generateHashid(): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt', 'default_salt'),
            config('hashids.connections.main.length', 8),
            config('hashids.connections.main.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')
        );

        $numericId = crc32($this->id ?? Str::uuid());
        return $hashids->encode($numericId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(CoinPackage::class, 'package_id');
    }

    public function coinPackage()
    {
        return $this->belongsTo(CoinPackage::class, 'package_id');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'processing']);
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['approved', 'declined']);
    }

    public static function findByHashid($hashid)
    {
        return static::where('hashid', $hashid)->first();
    }

    public function totalCoins()
    {
        return $this->base_coins + $this->bonus_coins;
    }
}