<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CoinPackage extends Model
{
    use HasFactory;

    // Set UUID as primary key and disable auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hashid',
        'pack_name',
        'coins',
        'bonus_coins',
        'price',
        'features',
        'badge_color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID if not set
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }

            // Generate hashid if not set
            if (empty($model->hashid)) {
                $model->hashid = $model->generateHashid();
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

    /**
     * Calculate total coins (base + bonus).
     */
    public function getTotalCoinsAttribute(): int
    {
        return $this->coins + $this->bonus_coins;
    }

    /**
     * Scope a query to only include active packages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order packages by sort_order then price.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    /**
     * Find a package by its hashid.
     */
    public static function findByHashid(string $hashid): ?CoinPackage
    {
        return static::where('hashid', $hashid)->first();
    }

    /**
     * Get the badge color with fallback to default.
     */
    protected function badgeColorWithDefault(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->badge_color ?? '#3B82F6' // Default blue-500
        );
    }
}
