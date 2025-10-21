<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Message extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'conversation_id', 'sender_id', 'message', 'type', 'file_path', 'file_name', 'file_size', 'mime_type', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (is_null($model->id)) {
                $model->id = Str::uuid();
            }
        });

        static::created(function ($model) {
            try {
                if ($model->conversation_id && $model->conversation) {
                    $model->conversation->update(['last_message_at' => $model->created_at]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to update conversation last_message_at: ' . $e->getMessage());
            }
        });
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function markAsRead()
    {
        if ($this->read_at) {
            return true;
        }
        
        try {
            $this->update(['read_at' => now()]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to mark message as read: ' . $e->getMessage(), [
                'message_id' => $this->id,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
    
    public function isImage()
    {
        return $this->type === 'image';
    }
    
    public function isVideo()
    {
        return $this->type === 'video';
    }
    
    public function isFile()
    {
        return $this->type === 'file';
    }
    
    public function isVoice()
    {
        return $this->type === 'voice';
    }
    
    public function getFileUrl()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}