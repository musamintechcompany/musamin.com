<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class Store extends Model
{
    // Set UUID as primary key and disable auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'name',
        'handle',
        'slug',
        'description',
        'logo',
        'banner',
        'theme_settings',
        'contact_info',
        'social_links',
        'shipping_settings',
        'tags',
        'is_active',
        'is_verified',
        'hashid'
    ];

    protected $casts = [
        'theme_settings' => 'array',
        'contact_info' => 'array',
        'social_links' => 'array',
        'shipping_settings' => 'array',
        'tags' => 'array',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                // Generate UUID if not set
                if (empty($model->id)) {
                    $model->id = Str::uuid();
                }

                // Auto-generate handle if not provided
                if (empty($model->handle)) {
                    $model->handle = $model->generateUniqueHandle($model->name);
                }

                // Generate slug if not set
                if (empty($model->slug)) {
                    $model->slug = $model->generateUniqueSlug($model->name);
                }

                // Generate hashid if not set (after UUID is set)
                if (empty($model->hashid)) {
                    $model->hashid = $model->generateHashid();
                }
            } catch (\Exception $e) {
                \Log::error('Store model boot error: ' . $e->getMessage());
                throw $e;
            }
        });
    }

    public function generateHashid(): string
    {
        try {
            $hashids = new Hashids(
                config('hashids.connections.main.salt'),
                config('hashids.connections.main.length'),
                config('hashids.connections.main.alphabet')
            );

            $numericId = crc32($this->id);
            return $hashids->encode($numericId);
        } catch (\Exception $e) {
            \Log::error('Hashid generation failed: ' . $e->getMessage());
            // Fallback to a simple hash if hashids fails
            return substr(md5($this->id), 0, 8);
        }
    }

    public function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        // Check for reserved words from database
        if (\App\Models\Reserved::isReserved($slug)) {
            throw new \InvalidArgumentException("The name '{$name}' is reserved and cannot be used as a store name. Please choose a different name.");
        }

        // Ensure uniqueness
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(StoreCategory::class);
    }

    public function orders()
    {
        return Order::where('order_type', 'store')
            ->whereJsonContains('order_data->store_id', $this->id);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Helper methods
    public static function findBySlug(string $slug): ?Store
    {
        return static::where('slug', $slug)->first();
    }

    public static function findByHashid(string $hashid): ?Store
    {
        return static::where('hashid', $hashid)->first();
    }

    public function generateUniqueHandle(string $name): string
    {
        $baseName = strtolower(str_replace(' ', '', $name));
        $baseName = preg_replace('/[^a-z0-9]/', '', $baseName);
        $baseName = substr($baseName, 0, 15);

        $handle = '@' . $baseName;
        $counter = 1;

        // Check for reserved words
        if (\App\Models\Reserved::isReserved($baseName)) {
            throw new \InvalidArgumentException("The name '{$name}' is reserved and cannot be used as a store name. Please choose a different name.");
        }

        // Ensure uniqueness
        while (static::where('handle', $handle)->exists()) {
            $handle = '@' . $baseName . $counter;
            $counter++;
        }

        return $handle;
    }

    public static function findByHandle(string $handle): ?Store
    {
        return static::where('handle', $handle)->first();
    }

    public function getUrlAttribute(): string
    {
        return url('/' . $this->handle);
    }
}
