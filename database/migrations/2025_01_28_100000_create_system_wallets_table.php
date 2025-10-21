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
        Schema::create('system_wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // 'coin_inflow', 'coin_outflow', 'revenue_inflow', 'withdrawal_outflow', etc.
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('running_balance', 15, 2)->default(0); // running total
            $table->uuidMorphs('transactionable'); // polymorphic to orders, coin_transactions, withdrawals, etc.
            $table->string('description')->nullable();
            $table->json('metadata')->nullable(); // additional data
            $table->timestamps();
            
            $table->index(['type', 'created_at']);
            $table->index(['running_balance']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_wallets');
    }
};