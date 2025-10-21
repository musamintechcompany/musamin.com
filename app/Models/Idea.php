<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Vinkla\Hashids\Facades\Hashids;

class Idea extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'custom_category',
        'description',
        'benefits',
        'media_files',
        'status',
        'hashid'
    ];
    
    protected $casts = [
        'media_files' => 'array',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($idea) {
            if (empty($idea->hashid)) {
                $idea->hashid = Hashids::encode(rand(100000, 999999));
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
