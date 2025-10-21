<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid column for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Foreign key to users
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Polymorphic relationship for future products
            $table->string('reviewable_type')->comment('Model class being reviewed');
            $table->uuid('reviewable_id')->comment('ID of the item being reviewed');
            
            // Review Details
            $table->integer('rating')->comment('1-5 star rating');
            $table->text('review_text')->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index(['reviewable_type', 'reviewable_id']);
            $table->index('rating');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};