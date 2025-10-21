<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'affiliate_code',
        'status',
        'joined_at',
        'expires_at',
        'fee_paid',
        'renewed_count',
        'renewal_history',
        'last_renewed_at',
        'plan_type',
        'reminder_7_days_sent_at',
        'reminder_24_hours_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
            'expires_at' => 'datetime',
            'fee_paid' => 'decimal:2',
            'renewal_history' => 'array',
            'last_renewed_at' => 'datetime',
            'reminder_7_days_sent_at' => 'datetime',
            'reminder_24_hours_sent_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isExpiringSoon(): bool
    {
        return $this->expires_at->diffInDays(now()) <= 30;
    }

    public function generateAffiliateCode(): string
    {
        do {
            $code = 'AFF-' . strtoupper(substr($this->user->hashid, 0, 6));
        } while (self::where('affiliate_code', $code)->exists());
        
        return $code;
    }
}