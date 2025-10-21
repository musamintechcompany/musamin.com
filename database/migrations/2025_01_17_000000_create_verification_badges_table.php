<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_badges', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->uuid('user_id');
            $table->enum('badge_type', ['identity', 'business', 'creator', 'celebrity'])->default('identity');
            $table->timestamp('verified_at');
            $table->uuid('verified_by')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('verification_reason')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->unique(['user_id', 'badge_type']);
            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_badges');
    }
};