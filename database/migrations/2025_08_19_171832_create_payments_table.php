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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            //Payment provider details
            $table->enum('provider', ['credit_card', 'paypal', 'stripe'])->default('stripe');
            
            //e.g., Stripe charge ID or PayPal transaction ID
            $table->string('provider_transaction_id')->unique();

            //e.g., Stripe customer ID or PayPal payer ID
            $table->string('provider_customer_id')->nullable();

            //e.g., Visa, MasterCard, etc.
            $table->string('card_brand')->nullable();
            
            //Last four digits of the card
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_exp_month', 2)->nullable();
            $table->string('card_exp_year', 4)->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('CAD');
            $table->enum('status', ['pending', 'succeeded', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
