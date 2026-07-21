<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('sku')->unique();
    $table->text('description');
    $table->string('short_description', 500)->nullable();
    
    // Prices & Stock
    $table->decimal('buy_price', 10, 2)->nullable();
    $table->decimal('price', 10, 2);
    $table->decimal('discount', 10, 2)->nullable();
    $table->integer('stock_quantity')->default(0);
    $table->integer('low_stock_threshold')->default(5);
    
    // Flags & Dates
    $table->boolean('is_active')->default(false);
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_new_arrival')->default(false);
    $table->boolean('is_bestseller')->default(false);
    $table->timestamp('published_at')->nullable();
    
    // Stats
    $table->unsignedInteger('views_count')->default(0);
    $table->unsignedInteger('sales_count')->default(0);
    
    // Limits
    $table->unsignedSmallInteger('min_order_quantity')->default(1);
    $table->unsignedSmallInteger('max_order_quantity')->nullable();
    
    // SEO
    $table->string('meta_title', 160)->nullable();
    $table->text('meta_description')->nullable();
    $table->string('meta_keywords')->nullable();
    $table->string('og_image')->nullable();
    
    // Logistics
    $table->decimal('weight', 8, 3)->nullable(); // kg
    $table->decimal('length', 8, 2)->nullable(); // cm
    $table->decimal('width', 8, 2)->nullable(); // cm
    $table->decimal('height', 8, 2)->nullable(); // cm
    
    // Flexible Cross-Category
    $table->json('tags')->nullable();
    $table->string('label', 50)->nullable();
    $table->text('ingredients')->nullable();
    $table->text('usage_instructions')->nullable();
    $table->string('warranty_info')->nullable();
    $table->string('origin_country', 100)->nullable();
    $table->json('certifications')->nullable();
    $table->string('material', 255)->nullable();
    $table->text('care_instructions')->nullable();
    
    $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
    $table->json('specifications')->nullable();
    
    $table->softDeletes();
    $table->timestamps();

    // 🚀 OPTIMIZED INDEXES FOR HIGH-SPEED QUERIES
    $table->index(['is_active', 'is_featured', 'category_id']);
    $table->index(['is_active', 'is_new_arrival']);
    $table->index(['is_active', 'is_bestseller']);
    $table->index(['is_active', 'brand_id']);
    $table->index('published_at');
    $table->index('views_count');
    $table->index('sales_count');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
