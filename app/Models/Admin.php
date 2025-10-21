<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Hashids\Hashids;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'admins';
    protected $guard_name = 'admin';
    
    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable')
                    ->orderBy('created_at', 'desc');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'theme',
        'hashid',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'password_reset_expires_at' => 'datetime',
        ];
    }

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

    public static function findByHashid(string $hashid): ?Admin
    {
        return static::where('hashid', $hashid)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }
}
