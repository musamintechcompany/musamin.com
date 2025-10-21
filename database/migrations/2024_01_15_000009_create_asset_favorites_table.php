<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_favorites', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Foreign keys
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->uuid('asset_id');
            $table->foreign('asset_id')->references('id')->on('digital_assets')->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('asset_id');
            $table->unique(['user_id', 'asset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_favorites');
    }
};