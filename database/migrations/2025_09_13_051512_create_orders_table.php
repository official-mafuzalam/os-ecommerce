<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();

            // Price columns
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('discount_code')->nullable();
            $table->decimal('total_amount', 12, 2);

            // Status columns
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'returned',
                'refunded',
                'cancelled'
            ])->default('pending');

            $table->enum('payment_method', [
                'cash_on_delivery',
                'bkash',
                'nagad',
                'rocket',
                'sslcommerz',
                'bank_transfer',
                'card'
            ])->default('cash_on_delivery');

            $table->enum('payment_status', [
                'pending',
                'authorized',
                'paid',
                'partially_paid',
                'refunded',
                'failed'
            ])->default('pending');

            // Shipping details
            $table->enum('shipping_method', ['standard', 'express', 'same_day'])->default('standard');
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->nullable();
            $table->timestamp('estimated_delivery_date')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('referral_source')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['order_number']);
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'payment_status']);
            $table->index(['created_at']);
            $table->index(['shipped_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};