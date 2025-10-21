<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop separate order tables - unified orders table handles all order types
        Schema::dropIfExists('asset_orders');
        Schema::dropIfExists('store_order_items');
        Schema::dropIfExists('store_orders');
    }

    public function down(): void
    {
        // Recreate tables if rollback needed
        Schema::create('asset_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('asset_id')->constrained('digital_assets')->onDelete('cascade');
            $table->enum('order_type', ['purchase', 'rental']);
            $table->decimal('amount_paid', 10, 2);
            $table->integer('coins_used')->default(0);
            $table->decimal('platform_share', 10, 2);
            $table->decimal('user_share', 10, 2);
            $table->boolean('system_managed_at_purchase')->default(false);
            $table->enum('rental_period', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('rental_duration')->nullable();
            $table->timestamp('rental_starts_at')->nullable();
            $table->timestamp('rental_expires_at')->nullable();
            $table->enum('purchase_type', ['source', 'hosting', 'enterprise', 'whitelabel'])->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('hashid')->unique();
            $table->timestamps();
        });

        Schema::create('store_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('store_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->integer('total_coins_used');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            $table->foreignUuid('delivery_detail_id')->nullable()->constrained()->onDelete('set null');
            $table->json('delivery_snapshot')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('store_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('store_orders')->onDelete('cascade');
            $table->foreignUuid('product_id')->constrained('store_products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }
};