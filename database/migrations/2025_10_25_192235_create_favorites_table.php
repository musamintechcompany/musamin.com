<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Foreign key to users
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Polymorphic relationship for any favoritable item
            $table->string('favoritable_type')->comment('Model class being favorited');
            $table->uuid('favoritable_id')->comment('ID of the item being favorited');
            
            // Optional metadata for additional information
            $table->json('metadata')->nullable()->comment('Additional data like notes, tags, etc.');
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index(['favoritable_type', 'favoritable_id']);
            $table->index('created_at');
            
            // Unique constraint to prevent duplicate favorites
            $table->unique(['user_id', 'favoritable_type', 'favoritable_id'], 'unique_user_favorite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};