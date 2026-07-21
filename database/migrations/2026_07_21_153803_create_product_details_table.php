<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->onDelete('cascade');

            // Content
            $table->text('description')->nullable();
            $table->string('short_description', 500)->nullable();

            // Logistics
            $table->decimal('weight', 8, 3)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

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
            $table->json('specifications')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
