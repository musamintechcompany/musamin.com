<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            
            // Personal Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            
            // Address Information
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            
            // ID Verification
            $table->enum('id_type', ['passport', 'drivers_license', 'national_id', 'voter_id'])->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_document_path')->nullable();
            $table->string('selfie_video_path')->nullable();
            
            // Utility Bill
            $table->enum('utility_type', ['electricity', 'water', 'gas', 'internet', 'phone', 'bank_statement'])->nullable();
            $table->string('utility_bill_path')->nullable();
            
            // Status & Timestamps
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('reviewer_notes')->nullable();
            $table->string('reviewed_by_name')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_verifications');
    }
};