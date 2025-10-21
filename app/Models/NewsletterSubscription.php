<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscription extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_UNSUBSCRIBED = 'unsubscribed';

    protected $fillable = [
        'email',
        'user_id',
        'status',
        'verification_token',
        'subscribed_at',
        'verified_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'verified_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function subscribe(string $email, ?User $user = null): array
    {
        $existing = static::where('email', $email)->first();
        
        if ($existing && $existing->status === self::STATUS_ACTIVE) {
            return ['success' => false, 'message' => 'Already subscribed'];
        }

        $subscription = $existing ?: new static(['email' => $email]);
        
        // If user is logged in and verified, activate immediately
        if ($user && $user->hasVerifiedEmail()) {
            $subscription->fill([
                'user_id' => $user->id,
                'status' => self::STATUS_ACTIVE,
                'subscribed_at' => now(),
                'verified_at' => now(),
                'verification_token' => null,
            ]);
            $message = 'Successfully subscribed to newsletter';
        } else {
            // Guest user - requires verification
            $subscription->fill([
                'user_id' => $user?->id,
                'status' => self::STATUS_INACTIVE,
                'subscribed_at' => now(),
                'verification_token' => Str::random(64),
            ]);
            // TODO: Send verification email
            $message = 'Verification email sent. Please check your inbox.';
        }

        $subscription->save();
        return ['success' => true, 'message' => $message];
    }

    public function verify(string $token): bool
    {
        if ($this->verification_token === $token) {
            $this->update([
                'status' => self::STATUS_ACTIVE,
                'verified_at' => now(),
                'verification_token' => null,
            ]);
            return true;
        }
        return false;
    }

    public function unsubscribe(): void
    {
        $this->update([
            'status' => self::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
        ]);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}