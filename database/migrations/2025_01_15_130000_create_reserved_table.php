<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserved', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('hashid')->nullable()->unique();
            $table->string('word')->unique();
            $table->string('type')->default('route'); // route, system, custom
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserved');
    }
};