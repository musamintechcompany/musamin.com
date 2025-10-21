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
        Schema::create('platform_wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // 'coin_inflow', 'coin_outflow', 'spending_add', 'earned_add', etc.
            $table->uuidMorphs('transactionable'); // polymorphic relation to users, orders, etc.
            $table->decimal('amount', 15, 2); // coin amount (can be negative for outflows)
            $table->json('data')->nullable(); // flexible data storage including totals
            $table->timestamps();
            
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_wallets');
    }
};