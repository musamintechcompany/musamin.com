<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class AssetFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'feature_text',
        'sort_order',
        'hashid',
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

    public static function findByHashid(string $hashid): ?AssetFeature
    {
        return static::where('hashid', $hashid)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    // Relationships
    public function asset()
    {
        return $this->belongsTo(DigitalAsset::class, 'asset_id');
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}