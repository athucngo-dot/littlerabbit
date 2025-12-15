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
                  ->cascadeOnDelete();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            //Payment provider details
            $table->enum('provider', ['stripe'])->default('stripe');
            
            //Primary reference for the payment
            $table->string('payment_intent_id')->nullable();

            //payment method id: For future charges / saving card
            $table->string('payment_method_id')->nullable();

            //Stripe charge ID
            $table->string('charge_id')->nullable()->unique();

            //e.g., Stripe customer ID
            $table->string('provider_customer_id')->nullable();

            // Visa, MasterCard, etc.
            $table->string('card_brand')->nullable();
            
            //Last four digits of the card
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_exp_month', 2)->nullable();
            $table->string('card_exp_year', 4)->nullable();

            $table->integer('amount')->default(0);
            $table->string('currency', 3)->default('CAD');
            $table->enum('status', ['pending', 'succeeded', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('failure_code')->nullable();
            $table->string('failure_message')->nullable();
            $table->timestamp('failed_at')->nullable();
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
