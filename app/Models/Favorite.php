<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
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
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritable()
    {
        return $this->morphTo();
    }

    // Helper methods
    public static function toggle($userId, $favoritable)
    {
        $favorite = static::where([
            'user_id' => $userId,
            'favoritable_type' => get_class($favoritable),
            'favoritable_id' => $favoritable->id,
        ])->first();

        if ($favorite) {
            $favorite->delete();
            return false; // Unfavorited
        } else {
            static::create([
                'user_id' => $userId,
                'favoritable_type' => get_class($favoritable),
                'favoritable_id' => $favoritable->id,
            ]);
            return true; // Favorited
        }
    }

    public static function isFavorited($userId, $favoritable): bool
    {
        return static::where([
            'user_id' => $userId,
            'favoritable_type' => get_class($favoritable),
            'favoritable_id' => $favoritable->id,
        ])->exists();
    }
}