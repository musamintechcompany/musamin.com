<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AssetFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
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
        });

        static::created(function ($model) {
            // Increment favorites count on asset
            $model->asset?->increment('favorites_count');
        });

        static::deleted(function ($model) {
            // Decrement favorites count on asset
            $model->asset?->decrement('favorites_count');
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(DigitalAsset::class, 'asset_id');
    }
}