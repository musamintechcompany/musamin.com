<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coin_transactions', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());

            // Hashid for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');

            // User Information (UUID foreign key)
            $table->uuid('user_id');
            $table->string('spending_wallet_id')->nullable();

            // Package Information (UUID foreign key, nullable for custom packages)
            $table->uuid('package_id')->nullable();
            $table->string('package_name');
            $table->integer('base_coins');
            $table->integer('bonus_coins')->default(0);
            $table->decimal('amount', 10, 2)->unsigned();

            // Payment Information
            $table->string('payment_type'); // manual/auto
            $table->string('payment_method'); // BTC, Bank Transfer, etc
            $table->json('payment_credentials')->nullable();

            // Timing Information
            $table->integer('countdown_time')->default(0);
            $table->integer('time_taken')->default(0);

            // Proof Information
            $table->json('proofs')->nullable();
            $table->text('user_notes')->nullable();

            // System Information
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Status Information
            $table->string('status')->default('pending'); // pending, processing, approved, declined
            $table->uuid('processed_by')->nullable();
            $table->text('staff_comments')->nullable();
            $table->string('decline_reason')->nullable();

            // Timestamps
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('coin_packages')->onDelete('set null');
            $table->foreign('spending_wallet_id')->references('spending_wallet_id')->on('users')->onDelete('set null');
            
            // Note: processed_by foreign key will be added after admins table is created
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coin_transactions');
    }
};
