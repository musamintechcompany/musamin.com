<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id', 36); // Fixed UUID length
            $table->char('product_id', 36); // Also fix product_id for consistency
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('store_name');
            $table->string('image')->nullable();
            $table->enum('type', ['digital', 'physical']);
            $table->integer('quantity')->default(1);
            $table->timestamps();
            
            $table->unique(['user_id', 'product_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
