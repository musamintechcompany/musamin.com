<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SystemWallet extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'currency',
        'running_balance',
        'transactionable_type',
        'transactionable_id',
        'description',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2',
        'running_balance' => 'decimal:2'
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
            
            // Calculate running balance
            $lastBalance = static::latest()->value('running_balance') ?? 0;
            $model->running_balance = $lastBalance + $model->amount;
        });
    }

    /**
     * Get the parent transactionable model.
     */
    public function transactionable()
    {
        return $this->morphTo();
    }

    /**
     * Get current system balance
     */
    public static function getCurrentBalance()
    {
        return static::latest()->value('running_balance') ?? 0;
    }

    /**
     * Scope for inflows (positive amounts)
     */
    public function scopeInflows($query)
    {
        return $query->where('amount', '>', 0);
    }

    /**
     * Scope for outflows (negative amounts)
     */
    public function scopeOutflows($query)
    {
        return $query->where('amount', '<', 0);
    }
}