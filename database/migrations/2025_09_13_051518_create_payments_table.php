<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            
            // Payment info
            $table->string('payment_number')->unique()->comment('e.g., PAY-20231215-0001');
            $table->string('transaction_id')->nullable();
            $table->string('gateway_transaction_id')->nullable();
            $table->enum('payment_method', [
                'cash_on_delivery',
                'bkash',
                'nagad',
                'rocket',
                'sslcommerz',
                'bank_transfer',
                'card'
            ]);
            
            // Amounts
            $table->decimal('amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->virtualAs('amount - paid_amount');

            // Status
            $table->enum('status', [
                'pending',
                'authorized',
                'processing',
                'completed',
                'partially_paid',
                'failed',
                'refunded',
                'cancelled',
                'expired'
            ])->default('pending');
            
            // Dates
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Gateway response
            $table->json('gateway_response')->nullable();
            $table->json('gateway_parameters')->nullable();
            $table->string('gateway_name')->nullable();
            
            // Additional info
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['order_id', 'status']);
            $table->index(['transaction_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};