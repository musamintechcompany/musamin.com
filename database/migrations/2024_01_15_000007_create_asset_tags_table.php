<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_tags', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Foreign keys
            $table->uuid('asset_id');
            $table->foreign('asset_id')->references('id')->on('digital_assets')->onDelete('cascade');
            
            $table->uuid('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes
            $table->index('asset_id');
            $table->index('tag_id');
            $table->unique(['asset_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_tags');
    }
};