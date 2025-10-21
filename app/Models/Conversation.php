<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Conversation extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_one_id', 'user_two_id', 'subject', 'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }



    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getOtherUser($userId)
    {
        // Validate userId to prevent SQL injection
        if (!is_string($userId) || !Str::isUuid($userId)) {
            throw new \InvalidArgumentException('User ID must be a valid UUID string');
        }
        
        return $this->user_one_id === $userId ? $this->userTwo : $this->userOne;
    }

    public static function findOrCreateBetween($userOneId, $userTwoId)
    {
        // Validate input parameters
        if (!is_string($userOneId) || !is_string($userTwoId)) {
            throw new \InvalidArgumentException('User IDs must be strings');
        }
        
        if (!Str::isUuid($userOneId) || !Str::isUuid($userTwoId)) {
            throw new \InvalidArgumentException('User IDs must be valid UUIDs');
        }
        
        if ($userOneId === $userTwoId) {
            throw new \InvalidArgumentException('Cannot create conversation with yourself');
        }

        // Use firstOrCreate to prevent race conditions
        $attributes = [
            'user_one_id' => $userOneId < $userTwoId ? $userOneId : $userTwoId,
            'user_two_id' => $userOneId < $userTwoId ? $userTwoId : $userOneId
        ];
        
        return static::firstOrCreate($attributes, [
            'last_message_at' => now()
        ]);
    }
}