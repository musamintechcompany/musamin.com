<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_assets', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid column for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Foreign keys
            $table->uuid('user_id')->comment('Asset owner (affiliate user)');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            
            $table->uuid('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
            
            // Basic Asset Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('asset_type', ['website', 'app', 'template', 'plugin', 'ui-kit', 'service', 'illustration', 'icon-set']);
            $table->text('short_description');
            $table->longText('details');
            $table->string('live_preview_url')->nullable();
            $table->string('readme_file_path')->nullable()->comment('Path to .md or .txt readme file');
            
            // Pricing
            $table->boolean('is_buyable')->default(true);
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->decimal('slashed_buy_price', 10, 2)->nullable()->comment('Original price before discount');
            
            $table->boolean('is_rentable')->default(false);
            $table->decimal('daily_rent_price', 8, 2)->nullable();
            $table->decimal('weekly_rent_price', 8, 2)->nullable();
            $table->decimal('monthly_rent_price', 8, 2)->nullable();
            $table->decimal('yearly_rent_price', 8, 2)->nullable();
            $table->decimal('slashed_rent_price', 8, 2)->nullable()->comment('Original rent price before discount');
            
            // Developer Info
            $table->boolean('is_team_work')->default(false);
            $table->json('developer_names')->nullable()->comment('Array of developer names');
            $table->json('developer_user_ids')->nullable()->comment('Array of user IDs if available');
            
            // Asset Management
            $table->boolean('system_managed')->default(true)->comment('Platform manages asset for 50% cut vs 30%');
            $table->string('asset_file_path')->nullable()->comment('Path to zip file');
            
            // Visibility & Status
            $table->boolean('is_public')->default(true)->comment('Public/private toggle');
            $table->enum('marketplace_status', ['live', 'removed', 'suspended'])->default('live');
            $table->enum('deletion_status', ['active', 'deleted'])->default('active');
            
            // Admin Inspection
            $table->enum('inspection_status', ['pending', 'approved', 'rejected', 'flagged'])->default('pending');
            $table->uuid('inspector_id')->nullable()->comment('Admin who inspected');
            $table->foreign('inspector_id')->references('id')->on('users')->onDelete('set null');
            $table->text('inspector_comment')->nullable();
            $table->timestamp('inspected_at')->nullable();
            
            // Features
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->integer('featured_coins_paid')->default(0);
            
            // License & Requirements
            $table->longText('license_info')->nullable();
            $table->json('requirements')->nullable()->comment('Array of requirements');
            
            // Stats
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->decimal('rating_average', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('category_id');
            $table->index('subcategory_id');
            $table->index('asset_type');
            $table->index('slug');
            $table->index('is_public');
            $table->index('marketplace_status');
            $table->index('deletion_status');
            $table->index('inspection_status');
            $table->index('is_featured');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_assets');
    }
};