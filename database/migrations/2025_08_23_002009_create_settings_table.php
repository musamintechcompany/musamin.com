<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary();

            // App Basic Settings
            $table->string('app_name')->nullable()->default('My App');

            // Fees
            $table->string('purchase_fee_type')->nullable()->default('percentage')
                ->comment('percentage or fixed');
            $table->decimal('purchase_fee', 10, 2)->nullable()->default(0)
                ->comment('Fee applied to coin purchases');

            $table->string('withdrawal_fee_type')->nullable()->default('percent')
                ->comment('percent or fixed');
            $table->decimal('withdrawal_fee', 10, 2)->nullable()->default(0)
                ->comment('Fee applied to cashouts');

            // SMS/Twilio Settings
            $table->boolean('sms_enabled')->nullable()->default(false)
                ->comment('Enable/disable SMS functionality');
            $table->string('twilio_sid')->nullable()
                ->comment('Twilio Account SID');
            $table->string('twilio_token')->nullable()
                ->comment('Twilio Auth Token');
            $table->string('twilio_from')->nullable()
                ->comment('Twilio phone number (+1234567890)');
            $table->string('sms_provider')->nullable()->default('twilio')
                ->comment('SMS provider: twilio, vonage, etc');

            // Email & Admin Settings
            $table->boolean('email_verification_required')->nullable()->default(false)
                ->comment('Require email verification on registration');
            $table->boolean('hide_admin_registration')->nullable()->default(false)
                ->comment('Hide admin registration page');

            // Terms & Privacy Settings
            $table->boolean('terms_privacy_required')->nullable()->default(false)
                ->comment('Require terms and privacy policy acceptance');

            // Profile Section Controls
            $table->boolean('profile_information_required')->nullable()->default(false)
                ->comment('Allow users to access profile information section');
            $table->boolean('password_change_required')->nullable()->default(false)
                ->comment('Allow users to change their password');
            $table->boolean('browser_sessions_required')->nullable()->default(false)
                ->comment('Allow users to view browser sessions');
            $table->boolean('two_factor_auth_required')->nullable()->default(false)
                ->comment('Allow users to setup two factor authentication');
            $table->boolean('account_deletion_required')->nullable()->default(false)
                ->comment('Allow users to delete their account');
            $table->boolean('kyc_enabled')->nullable()->default(false)
                ->comment('Enable/disable KYC verification requirement');

            // Coin Exchange & Withdrawal Settings
            $table->decimal('usd_to_coins_rate', 10, 2)->nullable()->default(100.00)
                ->comment('How many coins equal 1 USD');
            $table->decimal('minimum_withdrawal_amount', 10, 2)->nullable()->default(100.00)
                ->comment('Minimum coins required for withdrawal');

            // Affiliate Program Settings
            $table->decimal('affiliate_monthly_fee', 10, 2)->nullable()->default(3.00)
                ->comment('Monthly affiliate program fee in USD');
            $table->decimal('affiliate_yearly_fee', 10, 2)->nullable()->default(22.00)
                ->comment('Yearly affiliate program fee in USD');

            // Ideas Settings
            $table->boolean('ideas_enabled')->nullable()->default(false)
                ->comment('Enable/disable ideas functionality');

            // Inbox Settings
            $table->boolean('inbox_enabled')->nullable()->default(false)
                ->comment('Enable/disable inbox functionality');

            // Support System Settings Below
            // Live Chat Support Settings
            $table->boolean('live_chat_support_enabled')->nullable()->default(false)
                ->comment('Enable/disable live chat support functionality');

            // Request Callback Settings
            $table->boolean('request_callback_enabled')->nullable()->default(false)
                ->comment('Enable/disable request callback functionality');

            // FAQ Settings
            $table->boolean('faq_enabled')->nullable()->default(false)
                ->comment('Enable/disable FAQ functionality');

            // Help Center Settings
            $table->boolean('help_center_enabled')->nullable()->default(false)
                ->comment('Enable/disable help center functionality');

            // WhatsApp Settings
            $table->boolean('whatsapp_enabled')->nullable()->default(false)
                ->comment('Enable/disable WhatsApp functionality');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
