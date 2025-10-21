<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('order_number')->unique();
            $table->enum('order_type', ['store', 'asset']);
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->integer('total_coins_used')->default(0);
            $table->json('order_data'); // All order-specific details
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'created_at']);
            $table->index('order_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};