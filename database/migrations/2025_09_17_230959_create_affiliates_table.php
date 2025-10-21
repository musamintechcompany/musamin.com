<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->string('affiliate_code')->unique();
            $table->enum('status', ['active', 'expired', 'suspended', 'cancelled'])->default('active');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->decimal('fee_paid', 10, 2);
            $table->enum('plan_type', ['monthly', 'yearly'])->default('monthly');
            $table->integer('renewed_count')->default(0);
            $table->json('renewal_history')->nullable();
            $table->timestamp('last_renewed_at')->nullable();
            $table->timestamp('reminder_7_days_sent_at')->nullable();
            $table->timestamp('reminder_24_hours_sent_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliates');
    }
};