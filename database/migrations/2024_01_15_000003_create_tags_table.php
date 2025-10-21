<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid column for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Tag Details
            $table->string('name')->unique()->comment('Hashtag name without #');
            $table->string('slug')->unique();
            $table->integer('usage_count')->default(0)->comment('How many times this tag is used');
            
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('slug');
            $table->index('usage_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};