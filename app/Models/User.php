<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;
use Hashids\Hashids;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Mail\VerifyEmail;
use App\Mail\WelcomeEmail;
use App\Mail\EmailChangedSecurityAlert;
use App\Mail\Affiliate\AffiliateJoinSuccess;
use App\Mail\Affiliate\AffiliateRenewalSuccess;
use App\Mail\PasswordResetCode;
use App\Models\Affiliate;
use App\Models\Revenue;
use App\Models\SystemWallet;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    /* ==================== CONSTANTS ==================== */
    const STATUS_PENDING   = 'pending';
    const STATUS_ACTIVE    = 'active';
    const STATUS_WARNING   = 'warning';
    const STATUS_HOLD      = 'hold';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_BLOCKED   = 'blocked';
    const STATUS_DELETED   = 'deleted';

    const THEME_LIGHT = 'light';
    const THEME_DARK  = 'dark';

    const STATUSES = [
        self::STATUS_PENDING   => 'Pending',
        self::STATUS_ACTIVE    => 'Active',
        self::STATUS_WARNING   => 'Warning',
        self::STATUS_HOLD      => 'Hold',
        self::STATUS_SUSPENDED => 'Suspended',
        self::STATUS_BLOCKED   => 'Blocked',
        self::STATUS_DELETED   => 'Deleted',
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'date_of_birth',
        'country',
        'state',
        'address',
        'theme',
        'status',
        'spendable_coins',
        'earned_coins',
        'pending_earned_coins',
        'spending_wallet_id',
        'earned_wallet_id',
        'verification_code',
        'verification_code_expires_at',
        'hashid',
        'password_reset_code',
        'password_reset_code_expires_at',
        'pending_email',
        'email_change_step',
        'name_last_changed_at',
        'username_last_changed_at',
        'blocked_users',
        'last_seen_at',
        'is_online',
        'phone',
        'phone_verified_at',
        'phone_verification_code',
        'phone_verification_expires_at',
        'currency_id',
        'kyc_status',
        'city',
        'postal_code',
        'profile_photo_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',

        'verification_code',
        'phone_verification_code',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'          => 'datetime',
            'password'                   => 'hashed',
            'date_of_birth'              => 'date',
            'verification_code_expires_at' => 'datetime',

            'password_reset_code_expires_at' => 'datetime',
            'blocked_users'              => 'array',
            'last_seen_at'               => 'datetime',
            'is_online'                  => 'boolean',
            'phone_verified_at'          => 'datetime',
            'phone_verification_expires_at' => 'datetime',
            'two_factor_confirmed_at'    => 'datetime',
            'name_last_changed_at'       => 'datetime',
            'username_last_changed_at'   => 'datetime',
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

            if (empty($model->spending_wallet_id)) {
                $model->spending_wallet_id = 'SP' . $model->generateWalletId(9);
            }
            if (empty($model->earned_wallet_id)) {
                $model->earned_wallet_id = 'EN' . $model->generateWalletId(9);
            }

            // Check if email verification is required
            $settings = \App\Models\Setting::first();
            $emailVerificationRequired = $settings ? $settings->email_verification_required : false;

            if ($emailVerificationRequired) {
                $model->verification_code = $model->generateNumericVerificationCode();
                $model->verification_code_expires_at = now()->addSeconds(90);
                $model->status = self::STATUS_PENDING;
            } else {
                // If email verification is disabled, set user as active immediately
                $model->email_verified_at = now();
                $model->status = self::STATUS_ACTIVE;
            }



            // Auto-generate username if not provided
            if (empty($model->username)) {
                $model->username = $model->generateUniqueUsername();
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

    private function generateWalletId(int $length = 9): string
    {
        $characters = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function generateNumericVerificationCode(): string
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function generateUniqueUsername(): string
    {
        $baseName = strtolower(str_replace(' ', '', $this->name));
        $baseName = preg_replace('/[^a-z0-9]/', '', $baseName);
        $baseName = substr($baseName, 0, 10);

        $username = '@' . $baseName;
        $counter = 1;

        while (static::where('username', $username)->exists()) {
            $username = '@' . $baseName . $counter;
            $counter++;
        }

        return $username;
    }

    public static function findByHashid(string $hashid): ?User
    {
        return static::where('hashid', $hashid)->first();
    }

    public function verifyWithCode(string $code): bool
    {
        if ($this->hasVerifiedEmail()) {
            return true;
        }

        if (!$this->verification_code || !$this->verification_code_expires_at) {
            return false;
        }

        if ($this->verification_code_expires_at->isPast()) {
            return false;
        }

        if ($code === $this->verification_code) {
            // Check if this is registration verification (no pending_email)
            $isRegistration = !$this->pending_email;

            $this->update([
                'email_verified_at' => now(),
                'verification_code' => null,
                'verification_code_expires_at' => null,
                'status' => self::STATUS_ACTIVE
            ]);

            // Send welcome email only for registration, not email changes
            if ($isRegistration) {
                $this->sendDelayedWelcomeEmail();
            }

            return true;
        }

        return false;
    }

    public function generateNewVerificationCode(): string
    {
        $this->verification_code = $this->generateNumericVerificationCode();
        $this->verification_code_expires_at = now()->addSeconds(90);
        $this->save();
        return $this->verification_code;
    }

    /**
     * Send email verification notification (QUEUED to "emails" queue)
     */
    public function sendEmailVerificationNotification(): void
    {
        // Ensure verification code exists before sending
        if (!$this->verification_code) {
            $this->generateNewVerificationCode();
        }

        Mail::to($this->email)
            ->queue((new VerifyEmail($this))->onQueue('emails'));
    }

    /**
     * Send delayed welcome email (QUEUED to "emails" queue with 20s delay)
     */
    public function sendDelayedWelcomeEmail(): void
    {
        Mail::to($this->email)
            ->later(
                now()->addSeconds(20),
                (new WelcomeEmail($this))->onQueue('emails')
            );
    }

    /**
     * Send affiliate welcome email (QUEUED to "emails" queue)
     */
    public function sendAffiliateWelcomeEmail(int $feesPaid, string $planType = 'monthly'): void
    {
        Mail::to($this->email)
            ->queue((new AffiliateJoinSuccess($this, $feesPaid, $planType))->onQueue('emails'));
    }

    /**
     * Send affiliate renewal email (QUEUED to "emails" queue)
     */
    public function sendAffiliateRenewalEmail(int $feesPaid, string $planType = 'monthly'): void
    {
        Mail::to($this->email)
            ->queue((new AffiliateRenewalSuccess($this, $feesPaid, $planType))->onQueue('emails'));
    }

    /**
     * Generate and send password reset code
     */
    public function sendPasswordResetCode(): string
    {
        $code = $this->generateNumericVerificationCode();
        $this->update([
            'password_reset_code' => $code,
            'password_reset_code_expires_at' => now()->addMinutes(5)
        ]);

        Mail::to($this->email)
            ->queue((new PasswordResetCode($this, $code))->onQueue('emails'));

        return $code;
    }

    /**
     * Verify password reset code
     */
    public function verifyPasswordResetCode(string $code): bool
    {
        return $this->password_reset_code === $code &&
               $this->password_reset_code_expires_at &&
               $this->password_reset_code_expires_at->isFuture();
    }

    /**
     * Reset password with code
     */
    public function resetPasswordWithCode(string $code, string $newPassword): bool
    {
        if ($this->verifyPasswordResetCode($code)) {
            $this->update([
                'password' => Hash::make($newPassword),
                'password_reset_code' => null,
                'password_reset_code_expires_at' => null
            ]);
            return true;
        }
        return false;
    }

    /**
     * Initiate email change (double verification system)
     */
    public function initiateEmailChange(string $newEmail): void
    {
        // Store the new email and set step 1
        $this->update([
            'pending_email' => $newEmail,
            'email_change_step' => 'old_email_verification'
        ]);

        // Generate new verification code
        $this->generateNewVerificationCode();

        // Send verification code to the OLD email address for security
        Mail::to($this->email)
            ->queue((new VerifyEmail($this))->onQueue('emails'));
    }

    /**
     * Complete email change verification (handles both steps)
     */
    public function completeEmailChange(string $code): array
    {
        // Check if there's a pending email change and valid code
        if (!$this->pending_email ||
            $this->verification_code !== $code ||
            !$this->verification_code_expires_at ||
            $this->verification_code_expires_at->isPast()) {
            return ['success' => false, 'message' => 'Invalid or expired verification code'];
        }

        if ($this->email_change_step === 'old_email_verification') {
            // Step 1 completed - now verify new email
            $this->update([
                'email_change_step' => 'new_email_verification'
            ]);

            // Generate new code and send to NEW email
            $this->generateNewVerificationCode();
            Mail::to($this->pending_email)
                ->queue((new VerifyEmail($this))->onQueue('emails'));

            return [
                'success' => true,
                'step' => 'new_email_verification',
                'message' => 'Step 1 complete. Check your new email for verification code.'
            ];
        }

        if ($this->email_change_step === 'new_email_verification') {
            // Step 2 completed - finalize email change
            $oldEmail = $this->email;
            $newEmail = $this->pending_email;

            $this->update([
                'email' => $this->pending_email,
                'email_verified_at' => now(),
                'pending_email' => null,
                'email_change_step' => null,
                'verification_code' => null,
                'verification_code_expires_at' => null
            ]);

            // Send security alert to old email address
            Mail::to($oldEmail)
                ->queue((new EmailChangedSecurityAlert($this, $oldEmail, $newEmail))->onQueue('emails'));

            return [
                'success' => true,
                'step' => 'completed',
                'message' => 'Email changed successfully!'
            ];
        }

        return ['success' => false, 'message' => 'Invalid verification step'];
    }

    public function prefersDarkTheme(): bool
    {
        return $this->theme === self::THEME_DARK;
    }

    public function toggleTheme(): void
    {
        $this->theme = $this->prefersDarkTheme() ? self::THEME_LIGHT : self::THEME_DARK;
        $this->save();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    /* ==================== STATUS CHECKS ==================== */
    public function isActive(): bool { return $this->status === self::STATUS_ACTIVE; }
    public function isPending(): bool { return $this->status === self::STATUS_PENDING; }
    public function isWarning(): bool { return $this->status === self::STATUS_WARNING; }
    public function isOnHold(): bool { return $this->status === self::STATUS_HOLD; }
    public function isSuspended(): bool { return $this->status === self::STATUS_SUSPENDED; }
    public function isBlocked(): bool { return $this->status === self::STATUS_BLOCKED; }
    public function isDeleted(): bool { return $this->status === self::STATUS_DELETED; }

    /* ==================== AFFILIATE METHODS ==================== */

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function isAffiliate(): bool
    {
        return $this->affiliate && $this->affiliate->isActive();
    }

    public function becomeAffiliate(string $planType = 'monthly'): array
    {
        $settings = \App\Models\Setting::getSettings();
        $fee = $planType === 'yearly' ? $settings->affiliate_yearly_fee : $settings->affiliate_monthly_fee;
        $requiredCoins = $fee * ($settings->usd_to_coins_rate ?? 100);

        // Check if user has sufficient balance
        if ($this->spendable_coins < $requiredCoins) {
            return ['success' => false, 'message' => 'Insufficient balance'];
        }

        // Check if already affiliate
        if ($this->isAffiliate()) {
            return ['success' => false, 'message' => 'Already an affiliate member'];
        }

        // Calculate expiration date based on environment
        if (app()->environment('production')) {
            $expiresAt = $planType === 'yearly' ? now()->addYear() : now()->addMonth();
        } else {
            $expiresAt = $planType === 'yearly' ? now()->addHours(10) : now()->addMinutes(30);
        }

        // Create affiliate record
        $affiliate = Affiliate::create([
            'user_id' => $this->id,
            'affiliate_code' => $this->generateAffiliateCode(),
            'joined_at' => now(),
            'expires_at' => $expiresAt,
            'fee_paid' => $fee,
            'plan_type' => $planType,
        ]);

        // Deduct payment
        $this->update([
            'spendable_coins' => $this->spendable_coins - $requiredCoins,
        ]);

        // Create coin activity notification
        $planLabel = $planType === 'yearly' ? 'yearly' : 'monthly';
        $this->notifications()->create([
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\AffiliateFeeNotification',
            'data' => [
                'type' => 'affiliate_join',
                'message' => "Affiliate {$planLabel} plan fee: {$requiredCoins} coins",
                'amount' => $requiredCoins,
                'from_wallet' => 'spendable'
            ],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Record affiliate join fee as revenue
        Revenue::create([
            'type' => 'affiliate_join_fee',
            'revenueable_type' => User::class,
            'revenueable_id' => $this->id,
            'data' => [
                'amount' => $fee,
                'currency' => 'USD',
                'status' => 'confirmed',
                'plan_type' => $planType,
                'coins_deducted' => $requiredCoins,
                'usd_amount' => $fee,
                'affiliate_code' => $affiliate->affiliate_code
            ]
        ]);

        // Record in system wallet
        SystemWallet::create([
            'type' => 'affiliate_fee_inflow',
            'amount' => $fee,
            'transactionable_type' => User::class,
            'transactionable_id' => $this->id,
            'description' => "Affiliate {$planType} join fee from {$this->name}"
        ]);

        // Send affiliate welcome email
        $this->sendAffiliateWelcomeEmail($requiredCoins, $planType);

        // Send affiliate notification to user
        $this->notify(new \App\Notifications\Affiliate\AffiliateJoinedNotification());

        // Notify admins of new affiliate
        \App\Events\Admin\UserJoinedAffiliate::dispatch($this, $planType);

        return ['success' => true, 'message' => 'Successfully joined affiliate program'];
    }

    public function renewAffiliate(string $planType = 'monthly'): array
    {
        $settings = \App\Models\Setting::getSettings();
        $fee = $planType === 'yearly' ? $settings->affiliate_yearly_fee : $settings->affiliate_monthly_fee;
        $requiredCoins = $fee * ($settings->usd_to_coins_rate ?? 100);

        if ($this->spendable_coins < $requiredCoins) {
            return ['success' => false, 'message' => 'Insufficient balance for renewal'];
        }

        if (!$this->affiliate) {
            return ['success' => false, 'message' => 'No affiliate record found'];
        }

        // Calculate new expiration date based on environment
        if (app()->environment('production')) {
            $newExpiresAt = $planType === 'yearly' ? now()->addYear() : now()->addMonth();
        } else {
            $newExpiresAt = $planType === 'yearly' ? now()->addHours(10) : now()->addMinutes(30);
        }

        // Add to renewal history
        $renewalHistory = $this->affiliate->renewal_history ?? [];
        $renewalHistory[] = [
            'renewed_at' => now()->toISOString(),
            'previous_expiry' => $this->affiliate->expires_at->toISOString(),
            'new_expiry' => $newExpiresAt->toISOString(),
            'fee_paid' => $fee,
            'plan_type' => $planType,
        ];

        $this->affiliate->update([
            'expires_at' => $newExpiresAt,
            'status' => 'active',
            'renewed_count' => $this->affiliate->renewed_count + 1,
            'fee_paid' => $fee,
            'plan_type' => $planType,
            'renewal_history' => $renewalHistory,
            'last_renewed_at' => now(),
            'reminder_7_days_sent_at' => null,
            'reminder_24_hours_sent_at' => null,
        ]);

        $this->update([
            'spendable_coins' => $this->spendable_coins - $requiredCoins,
        ]);

        // Create coin activity notification for renewal
        $planLabel = $planType === 'yearly' ? 'yearly' : 'monthly';
        $this->notifications()->create([
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\AffiliateFeeNotification',
            'data' => [
                'type' => 'affiliate_renewal',
                'message' => "Affiliate {$planLabel} renewal fee: {$requiredCoins} coins",
                'amount' => $requiredCoins,
                'from_wallet' => 'spendable'
            ],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Record affiliate renewal fee as revenue
        Revenue::create([
            'type' => 'affiliate_renewal_fee',
            'revenueable_type' => User::class,
            'revenueable_id' => $this->id,
            'data' => [
                'amount' => $fee,
                'currency' => 'USD',
                'status' => 'confirmed',
                'plan_type' => $planType,
                'coins_deducted' => $requiredCoins,
                'usd_amount' => $fee,
                'affiliate_code' => $this->affiliate->affiliate_code,
                'renewal_count' => $this->affiliate->renewed_count
            ]
        ]);

        // Record in system wallet
        SystemWallet::create([
            'type' => 'affiliate_fee_inflow',
            'amount' => $fee,
            'transactionable_type' => User::class,
            'transactionable_id' => $this->id,
            'description' => "Affiliate {$planType} renewal fee from {$this->name}"
        ]);

        // Send affiliate renewal email
        $this->sendAffiliateRenewalEmail($requiredCoins, $planType);

        // Send affiliate renewal notification to user
        $this->notify(new \App\Notifications\Affiliate\AffiliateRenewedNotification());

        // Notify admins of affiliate renewal
        \App\Events\Admin\UserRenewedAffiliate::dispatch($this, $planType);

        return ['success' => true, 'message' => 'Affiliate membership renewed successfully'];
    }

    public function isAffiliateExpiringSoon(): bool
    {
        return $this->affiliate &&
               $this->affiliate->status === 'active' &&
               $this->affiliate->isExpiringSoon();
    }

    private function generateAffiliateCode(): string
    {
        do {
            $code = 'AFF-' . strtoupper(substr($this->hashid, 0, 6));
        } while (Affiliate::where('affiliate_code', $code)->exists());

        return $code;
    }

    public function getAffiliateLink(): string
    {
        return $this->affiliate ? url('/join?ref=' . $this->affiliate->affiliate_code) : '';
    }

    /* ==================== RELATIONSHIPS ==================== */

    /**
     * Get the user's store
     */
    public function store()
    {
        return $this->hasOne(\App\Models\Store::class);
    }

    /**
     * Get the user's orders as a customer
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'user_id');
    }

    /**
     * Get orders for the user's store
     */
    public function storeOrders()
    {
        return $this->hasMany(\App\Models\Order::class, 'user_id')
            ->where('order_type', 'store')
            ->whereJsonContains('order_data->store_id', $this->store->id ?? null);
    }

    /**
     * Get conversations where user is participant
     */
    public function conversations()
    {
        return \App\Models\Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }

    /* ==================== BLOCKING METHODS ==================== */

    /**
     * Block a user
     */
    public function blockUser($userId)
    {
        $blockedUsers = $this->blocked_users ?? [];
        if (!in_array($userId, $blockedUsers)) {
            $blockedUsers[] = $userId;
            $this->update(['blocked_users' => $blockedUsers]);
        }
    }

    /**
     * Unblock a user
     */
    public function unblockUser($userId)
    {
        $blockedUsers = $this->blocked_users ?? [];
        $blockedUsers = array_values(array_filter($blockedUsers, fn($id) => $id !== $userId));
        $this->update(['blocked_users' => $blockedUsers]);
    }

    /**
     * Check if user has blocked another user
     */
    public function hasBlocked($userId)
    {
        return in_array($userId, $this->blocked_users ?? []);
    }

    /**
     * Check if user is blocked by another user
     */
    public function isBlockedBy($userId)
    {
        if (!$userId || !is_string($userId)) {
            return false;
        }

        $user = static::find($userId);
        return $user ? $user->hasBlocked($this->id) : false;
    }

    /* ==================== FOLLOW METHODS ==================== */

    /**
     * Follow a user
     */
    public function follow($userId)
    {
        if ($userId === $this->id) return false; // Can't follow yourself

        return \App\Models\Follow::firstOrCreate([
            'follower_id' => $this->id,
            'following_id' => $userId
        ]);
    }

    /**
     * Unfollow a user
     */
    public function unfollow($userId)
    {
        return \App\Models\Follow::where('follower_id', $this->id)
            ->where('following_id', $userId)
            ->delete();
    }

    /**
     * Check if following a user
     */
    public function isFollowing($userId)
    {
        return \App\Models\Follow::where('follower_id', $this->id)
            ->where('following_id', $userId)
            ->exists();
    }

    /**
     * Get users this user is following
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Get users following this user
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Get followers count
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    /**
     * Get following count
     */
    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }

    /* ==================== VERIFICATION BADGE METHODS ==================== */

    /**
     * Get user's preferred currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get user's KYC verification
     */
    public function kycVerification()
    {
        return $this->hasOne(KycVerification::class);
    }

    /**
     * Get user's verification badges
     */
    public function verificationBadges()
    {
        return $this->hasMany(\App\Models\VerificationBadge::class);
    }

    /**
     * Get user's withdrawal details
     */
    public function withdrawalDetails()
    {
        return $this->hasMany(\App\Models\WithdrawalDetail::class);
    }

    /**
     * Get user's delivery details
     */
    public function deliveryDetails()
    {
        return $this->hasMany(\App\Models\DeliveryDetail::class);
    }

    /**
     * Check if user has any active verification badge
     */
    public function hasVerificationBadge($type = null)
    {
        $query = $this->verificationBadges()->where('is_active', true);

        if ($type) {
            $query->where('badge_type', $type);
        }

        return $query->whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->exists();
    }

    /**
     * Alias for hasVerificationBadge()
     */
    public function isVerified($type = null)
    {
        return $this->hasVerificationBadge($type);
    }

    /**
     * Get active verification badge
     */
    public function getVerificationBadge($type = null)
    {
        $query = $this->verificationBadges()->where('is_active', true);

        if ($type) {
            $query->where('badge_type', $type);
        }

        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        })->first();
    }

    /* ==================== SMS/PHONE METHODS ==================== */

    /**
     * Send phone verification SMS
     */
    public function sendPhoneVerificationCode()
    {
        if (!$this->phone) {
            return ['success' => false, 'message' => 'No phone number provided'];
        }

        $code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

        $this->update([
            'phone_verification_code' => $code,
            'phone_verification_expires_at' => now()->addMinutes(10)
        ]);

        try {
            $settings = \App\Models\Setting::first();

            if (!$settings || !$settings->sms_enabled || !$settings->twilio_sid) {
                return ['success' => false, 'message' => 'SMS service not configured'];
            }

            $twilio = new \Twilio\Rest\Client($settings->twilio_sid, $settings->twilio_token);

            $twilio->messages->create($this->phone, [
                'from' => $settings->twilio_from,
                'body' => "Your verification code is: {$code}"
            ]);

            return ['success' => true, 'message' => 'Verification code sent'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send SMS'];
        }
    }

    /**
     * Verify phone with code
     */
    public function verifyPhone($code)
    {
        if ($this->phone_verification_code === $code &&
            $this->phone_verification_expires_at &&
            $this->phone_verification_expires_at->isFuture()) {

            $this->update([
                'phone_verified_at' => now(),
                'phone_verification_code' => null,
                'phone_verification_expires_at' => null
            ]);

            return true;
        }

        return false;
    }

    /**
     * Check if phone is verified
     */
    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Check if email verification is required based on settings
     */
    public function isEmailVerificationRequired()
    {
        $settings = \App\Models\Setting::first();
        return $settings ? $settings->email_verification_required : false;
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail()
    {
        if (!$this->isEmailVerificationRequired()) {
            return true; // If verification not required, consider as verified
        }
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified (Laravel's expected method).
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send welcome email if email verification is disabled
     */
    public function sendWelcomeEmailIfNoVerification()
    {
        if (!$this->isEmailVerificationRequired()) {
            $this->sendDelayedWelcomeEmail();
        }
    }

    /* ==================== PROFILE PHOTO METHODS ==================== */

    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Delete the user's profile photo.
     */
    public function deleteProfilePhoto()
    {
        if ($this->profile_photo_path) {
            Storage::disk('public')->delete($this->profile_photo_path);
            $this->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }
    }
}
