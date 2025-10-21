<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Owner Information
            $table->uuid('user_id');
            
            // Store Identity
            $table->string('name')->comment('Store display name');
            $table->string('handle')->unique()->comment('Unique handle with @ prefix');
            $table->string('slug')->unique()->comment('URL-friendly store identifier');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            
            // Store Settings
            $table->json('theme_settings')->nullable()->comment('Store theme customization');
            $table->json('contact_info')->nullable()->comment('Store contact details');
            $table->json('social_links')->nullable()->comment('Social media links');
            $table->json('shipping_settings')->nullable()->comment('Store shipping configuration');
            
            // Business Information
            $table->json('tags')->nullable();
            
            // Status & Control
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            // Analytics
            $table->integer('visits_count')->default(0);
            $table->integer('followers_count')->default(0);
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index(['is_active', 'is_verified']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};