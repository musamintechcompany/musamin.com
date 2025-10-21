<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class Review extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'rating',
        'review_text',
        'is_verified_purchase',
        'status',
        'hashid',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

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

        static::created(function ($model) {
            // Update the reviewable item's rating
            if ($model->reviewable && method_exists($model->reviewable, 'updateRating')) {
                $model->reviewable->updateRating();
            }
        });

        static::updated(function ($model) {
            // Update the reviewable item's rating
            if ($model->reviewable && method_exists($model->reviewable, 'updateRating')) {
                $model->reviewable->updateRating();
            }
        });

        static::deleted(function ($model) {
            // Update the reviewable item's rating
            if ($model->reviewable && method_exists($model->reviewable, 'updateRating')) {
                $model->reviewable->updateRating();
            }
        });
    }

    public function generateHashid(): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length'),
            config('hashids.connections.main.alphabet')
        );

        $numericId = crc32($this->id);
        return $hashids->encode($numericId);
    }

    public static function findByHashid(string $hashid): ?Review
    {
        return static::where('hashid', $hashid)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    // Methods
    public function approve()
    {
        $this->update(['status' => self::STATUS_APPROVED]);
    }

    public function reject()
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}