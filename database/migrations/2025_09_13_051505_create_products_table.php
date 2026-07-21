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
            
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            
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
