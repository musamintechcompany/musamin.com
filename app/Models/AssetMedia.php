<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class AssetMedia extends Model
{
    use HasFactory;

    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VIDEO = 'video';

    protected $fillable = [
        'asset_id',
        'media_type',
        'file_path',
        'thumbnail_path',
        'alt_text',
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

    public static function findByHashid(string $hashid): ?AssetMedia
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
    public function scopeImages($query)
    {
        return $query->where('media_type', self::MEDIA_TYPE_IMAGE);
    }

    public function scopeVideos($query)
    {
        return $query->where('media_type', self::MEDIA_TYPE_VIDEO);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Methods
    public function isImage(): bool
    {
        return $this->media_type === self::MEDIA_TYPE_IMAGE;
    }

    public function isVideo(): bool
    {
        return $this->media_type === self::MEDIA_TYPE_VIDEO;
    }

    public function getDisplayPath(): string
    {
        if ($this->isVideo() && $this->thumbnail_path) {
            return $this->thumbnail_path;
        }
        
        return $this->file_path;
    }
}