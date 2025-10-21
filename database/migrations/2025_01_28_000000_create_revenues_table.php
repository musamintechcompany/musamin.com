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
        Schema::create('revenues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // 'external_transfer_fee', 'affiliate_join_fee', etc.
            $table->uuidMorphs('revenueable'); // polymorphic relation to users, orders, etc.
            $table->json('data'); // flexible data storage (amount, currency, status, etc.)
            $table->timestamps();
            
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};