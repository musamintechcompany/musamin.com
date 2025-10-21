<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'usage_count',
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

            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
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

    public static function findByHashid(string $hashid): ?Tag
    {
        return static::where('hashid', $hashid)->first();
    }

    public static function findOrCreateByName(string $name): Tag
    {
        $slug = Str::slug($name);
        
        $tag = static::where('name', $name)->orWhere('slug', $slug)->first();
        
        if (!$tag) {
            $tag = static::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
        
        return $tag;
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    // Relationships
    public function digitalAssets()
    {
        return $this->belongsToMany(DigitalAsset::class, 'asset_tags');
    }

    // Methods
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function decrementUsage()
    {
        $this->decrement('usage_count');
    }

    // Scopes
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }
}