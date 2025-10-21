<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coin_packages', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');

            // Package Identification
            $table->string('pack_name')->comment('Display name/tier (e.g., "Starter", "Pro")');

            // Coin Quantities
            $table->integer('coins')->unsigned()->comment('Base coin amount included in package');
            $table->integer('bonus_coins')->unsigned()->default(0)->comment('Additional bonus coins (promotional)');

            // Pricing
            $table->decimal('price', 8, 2)->comment('USD price of the package');

            // Package Features
            $table->json('features')->nullable()->comment('JSON array of feature descriptions');

            // Visual Display
            $table->string('badge_color')->nullable()->comment('Hex color code for package badge styling');

            // Control Flags
            $table->boolean('is_active')->default(true)->comment('Whether package is available for purchase');
            $table->integer('sort_order')->default(0)->comment('Display ordering priority');

            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'sort_order'], 'coin_packages_active_sorted_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coin_packages');
    }
};