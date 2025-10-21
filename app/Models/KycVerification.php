<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KycVerification extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'phone',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'id_type',
        'id_number',
        'id_document_path',
        'selfie_video_path',
        'utility_type',
        'utility_bill_path',
        'status',
        'rejection_reason',
        'reviewer_notes',
        'reviewed_by_name',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
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

    /**
     * Get the user that owns the KYC verification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who reviewed this KYC
     */
    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    /**
     * Check if KYC is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if KYC is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if KYC is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Mark as submitted
     */
    public function markAsSubmitted()
    {
        $this->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);
        
        // Update user KYC status
        $this->user->update(['kyc_status' => 'pending']);
    }

    /**
     * Approve KYC
     */
    public function approve($reviewerName = null, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by_name' => $reviewerName,
            'reviewer_notes' => $notes,
            'rejection_reason' => null,
        ]);
        
        // Update user KYC status
        $this->user->update(['kyc_status' => 'approved']);
    }

    /**
     * Reject KYC
     */
    public function reject($reason, $reviewerName = null, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by_name' => $reviewerName,
            'reviewer_notes' => $notes,
            'rejection_reason' => $reason,
        ]);
        
        // Update user KYC status
        $this->user->update(['kyc_status' => 'rejected']);
    }
}