<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->uuid('store_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('list_price', 10, 2)->nullable();
            $table->string('category')->nullable();
            $table->enum('type', ['digital', 'physical'])->default('digital');
            $table->json('images')->nullable();
            $table->string('file_path')->nullable(); // For digital products
            $table->integer('stock_quantity')->nullable(); // For physical products
            $table->boolean('is_active')->default(true);
            $table->json('specifications')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
            
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->index(['store_id', 'is_active']);
            $table->index('price');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_products');
    }
};
