<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());

            // Hashid for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');

            // Core Identification
            $table->string('name')->comment('Display name of payment method');
            $table->string('code')->unique()->comment('BTC, NGN, ETH, etc - Short unique code');
            $table->enum('type', ['automatic', 'manual'])->default('manual')->comment('Type of payment processing');
            $table->enum('category', ['crypto', 'bank'])->comment('Category of payment method');

            // Visual & UX
            $table->string('icon')->comment('Font Awesome icon class for display');
            $table->integer('countdown_time')->default(180)->comment('Payment timeout duration in seconds (for manual methods)');

            // Financial Configuration
            $table->decimal('usd_rate', 16, 8)->comment('Exchange rate against USD');
            $table->string('currency_symbol')->nullable()->comment('Currency symbol for bank methods (e.g. ₦, $)');

            // Type-Specific Storage
            $table->json('crypto_credentials')->nullable()->comment('JSON structure for crypto wallet details');
            $table->json('bank_credentials')->nullable()->comment('JSON structure for bank account details');

            // Control Flags
            $table->boolean('is_active')->default(true)->comment('Whether method is active for use');
            $table->boolean('has_fee')->default(true)->comment('Whether platform fees apply');
            $table->integer('sort_order')->default(0)->comment('Display ordering priority');

            $table->timestamps();

            // Indexes
            $table->index(['type', 'category', 'is_active'], 'payment_method_type_category_active_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
