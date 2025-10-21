<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    // Set UUID as primary key and disable auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'app_name',
        'purchase_fee_type',
        'purchase_fee',
        'withdrawal_fee_type',
        'withdrawal_fee',
        'sms_enabled',
        'twilio_sid',
        'twilio_token',
        'twilio_from',
        'sms_provider',
        'email_verification_required',
        'hide_admin_registration',
        'terms_privacy_required',
        'profile_information_required',
        'password_change_required',
        'browser_sessions_required',
        'two_factor_auth_required',
        'account_deletion_required',
        'kyc_enabled',
        'usd_to_coins_rate',
        'minimum_withdrawal_amount',
        'affiliate_monthly_fee',
        'affiliate_yearly_fee',
        'ideas_enabled',
        'inbox_enabled',
        'live_chat_support_enabled',
        'request_callback_enabled',
        'faq_enabled',
        'help_center_enabled',
        'whatsapp_enabled',
    ];

    protected $casts = [
        'purchase_fee'   => 'decimal:2',
        'withdrawal_fee' => 'decimal:2',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID if not set
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    /**
     * Get the first settings record or create a default one.
     */
    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'app_name'          => 'My App',
            'purchase_fee_type' => 'percent',
            'purchase_fee'      => 0,
            'withdrawal_fee_type' => 'percent',
            'withdrawal_fee'    => 0,
        ]);
    }
}
