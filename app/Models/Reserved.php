<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class Reserved extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'reserved';

    protected $fillable = ['word', 'type', 'reason', 'hashid'];

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

    public static function isReserved(string $word): bool
    {
        return static::where('word', strtolower($word))->exists();
    }

    public static function addReservedWords(array $words, string $type = 'route', string $reason = null): void
    {
        foreach ($words as $word) {
            static::firstOrCreate(
                ['word' => strtolower($word)],
                ['type' => $type, 'reason' => $reason]
            );
        }
    }
}