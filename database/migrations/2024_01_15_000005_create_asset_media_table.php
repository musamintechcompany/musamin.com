<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_media', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid column for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Foreign key to digital_assets
            $table->uuid('asset_id');
            $table->foreign('asset_id')->references('id')->on('digital_assets')->onDelete('cascade');
            
            // Media Details
            $table->enum('media_type', ['image', 'video']);
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable()->comment('For video thumbnails');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('asset_id');
            $table->index('media_type');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_media');
    }
};