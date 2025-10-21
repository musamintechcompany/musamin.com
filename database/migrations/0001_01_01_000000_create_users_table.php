<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // UUID as primary key instead of auto-incrementing ID
            $table->uuid('id')->primary()->default(Str::uuid());

            // Hashid column for public-facing identifiers (URLs, APIs)
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');

            // User Details
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('language', 5)->nullable()->default('en')->comment('User preferred language (en, es, fr, etc)');
            
            // Two Factor Authentication
            $table->text('two_factor_secret')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->nullable();

            $table->timestamp('two_factor_confirmed_at')
                ->nullable();
                
            $table->rememberToken();

            // Location Fields (All Nullable)
            $table->string('country', 100)->nullable()
                ->comment('User-entered country');
            $table->string('state', 100)->nullable()
                ->comment('User-entered state/province');
            $table->string('city', 100)->nullable()
                ->comment('User-entered city');
            $table->string('postal_code', 20)->nullable()
                ->comment('User-entered postal/zip code');
            $table->text('address')->nullable()
                ->comment('Full street address');

            // Status Management
            $table->string('status')->default('pending');

            // Theme Preference
            $table->string('theme')->default('light')
                ->comment('User interface theme preference: light or dark');

            // Coin System
            $table->unsignedBigInteger('spendable_coins')->default(0);
            $table->unsignedBigInteger('earned_coins')->default(0);
            $table->unsignedBigInteger('pending_earned_coins')->default(0)
                ->comment('Coins on hold until order completion');

            // Wallet System
            $table->string('spending_wallet_id')->nullable()->unique();
            $table->string('earned_wallet_id')->nullable()->unique();

            // Email Verification
            $table->string('verification_code', 6)->nullable();
            $table->timestamp('verification_code_expires_at')->nullable();

            // Affiliate System


            // Password Reset System
            $table->string('password_reset_code', 6)->nullable();
            $table->timestamp('password_reset_code_expires_at')->nullable();

            // Email Change System
            $table->string('pending_email')->nullable();
            $table->string('email_change_step')->nullable()->comment('old_email_verification or new_email_verification');
            
            // Name/Username Change Tracking
            $table->timestamp('name_last_changed_at')->nullable();
            $table->timestamp('username_last_changed_at')->nullable();

            // Phone System
            $table->string('phone', 20)->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('phone_verification_code', 6)->nullable();
            $table->timestamp('phone_verification_expires_at')->nullable();

            // Online Status Tracking
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_online')->default(false);

            // Currency Preference
            $table->string('currency_id', 3)->nullable()
                ->comment('User preferred withdrawal currency');

            // KYC Status
            $table->enum('kyc_status', ['not_started', 'pending', 'approved', 'rejected'])
                ->default('not_started')
                ->comment('KYC verification status');

            // Blocked Users
            $table->json('blocked_users')->nullable();

            // Framework Fields
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('email');
            $table->index('username');
            $table->index('name');
            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
