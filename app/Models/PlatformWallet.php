<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlatformWallet extends Model
{
    protected $fillable = [
        'type',
        'transactionable_type',
        'transactionable_id',
        'amount',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'amount' => 'decimal:2'
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
            
            // Calculate running totals from current platform state
            $latest = static::latest()->first();
            $currentTotals = $latest->data ?? [];
            
            $totalSpending = $currentTotals['total_spending_coins'] ?? 0;
            $totalEarned = $currentTotals['total_earned_coins'] ?? 0;
            $totalPending = $currentTotals['total_pending_earned_coins'] ?? 0;
            $platformBalance = $currentTotals['platform_balance'] ?? 0;
            
            // Update totals based on transaction type
            switch ($model->type) {
                case 'spending_add':
                    $totalSpending += $model->amount;
                    $platformBalance += $model->amount;
                    break;
                case 'spending_deduct':
                    $totalSpending -= $model->amount;
                    $platformBalance -= $model->amount;
                    break;
                case 'earned_add':
                    $totalEarned += $model->amount;
                    $platformBalance += $model->amount;
                    break;
                case 'earned_deduct':
                    $totalEarned -= $model->amount;
                    $platformBalance -= $model->amount;
                    break;
                case 'pending_earned_add':
                    $totalPending += $model->amount;
                    break;
                case 'pending_earned_deduct':
                    $totalPending -= $model->amount;
                    break;
                case 'pending_to_earned_transfer':
                    $totalPending -= $model->amount;
                    $totalEarned += $model->amount;
                    break;
            }
            
            // Store totals in data JSON field
            $data = $model->data ?? [];
            $data['total_spending_coins'] = $totalSpending;
            $data['total_earned_coins'] = $totalEarned;
            $data['total_pending_earned_coins'] = $totalPending;
            $data['platform_balance'] = $platformBalance;
            
            // Track total revenue coins (company earnings)
            $totalRevenue = $currentTotals['total_revenue_coins'] ?? 0;
            if (in_array($model->type, ['revenue_add', 'fee_collected'])) {
                $totalRevenue += $model->amount;
            } elseif (in_array($model->type, ['revenue_deduct', 'refund_issued'])) {
                $totalRevenue -= $model->amount;
            }
            $data['total_revenue_coins'] = $totalRevenue;
            
            $model->data = $data;
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
     * Get current platform totals
     */
    public static function getCurrentTotals()
    {
        $latest = static::latest()->first();
        $data = $latest->data ?? [];
        
        return [
            'total_spending_coins' => $data['total_spending_coins'] ?? 0,
            'total_earned_coins' => $data['total_earned_coins'] ?? 0,
            'total_pending_earned_coins' => $data['total_pending_earned_coins'] ?? 0,
            'platform_balance' => $data['platform_balance'] ?? 0,
            'total_revenue_coins' => $data['total_revenue_coins'] ?? 0,
        ];
    }

    /**
     * Record coin transaction
     */
    public static function recordTransaction($type, $amount, $transactionable, $data = [])
    {
        return static::create([
            'type' => $type,
            'amount' => abs($amount),
            'transactionable_type' => get_class($transactionable),
            'transactionable_id' => $transactionable->id,
            'data' => $data
        ]);
    }

    /**
     * Scope for inflows (positive amounts)
     */
    public function scopeInflows($query)
    {
        return $query->whereIn('type', ['spending_add', 'earned_add', 'pending_earned_add']);
    }

    /**
     * Scope for outflows (negative amounts)
     */
    public function scopeOutflows($query)
    {
        return $query->whereIn('type', ['spending_deduct', 'earned_deduct', 'pending_earned_deduct']);
    }
}