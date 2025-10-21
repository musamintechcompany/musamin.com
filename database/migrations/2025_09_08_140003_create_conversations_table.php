<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_one_id');
            $table->uuid('user_two_id');
            $table->uuid('product_id')->nullable(); // For product-specific conversations
            $table->string('subject')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            $table->foreign('user_one_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_two_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('store_products')->onDelete('set null');
            
            $table->unique(['user_one_id', 'user_two_id', 'product_id']);
            $table->index(['user_one_id', 'user_two_id', 'product_id']);
            $table->index(['user_two_id', 'user_one_id', 'product_id']);
            $table->index('last_message_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};