<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Revenue extends Model
{
    protected $fillable = [
        'type',
        'revenueable_type',
        'revenueable_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            
            // Ensure recorded_at is set in data
            $data = $model->data ?? [];
            if (!isset($data['recorded_at'])) {
                $data['recorded_at'] = now()->toISOString();
            }
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }
            if (!isset($data['currency'])) {
                $data['currency'] = 'USD';
            }
            $model->data = $data;
        });
    }

    /**
     * Get the parent revenueable model.
     */
    public function revenueable()
    {
        return $this->morphTo();
    }

    /**
     * Scope for confirmed revenues only
     */
    public function scopeConfirmed($query)
    {
        return $query->whereJsonContains('data->status', 'confirmed');
    }
    
    /**
     * Get amount from data
     */
    public function getAmountAttribute()
    {
        return $this->data['amount'] ?? 0;
    }
    
    /**
     * Get status from data
     */
    public function getStatusAttribute()
    {
        return $this->data['status'] ?? 'pending';
    }

    /**
     * Scope by revenue type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}