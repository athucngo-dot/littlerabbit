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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();
            $table->enum ('status', ['pending', 'paid', 'failed', 'shipping', 'delivered', 'cancelled'])->default('pending');
            $table->string('stripe_payment_intent_id')
                  ->index()
                  ->nullable();
            $table->decimal('subtotal', 8, 2)->default(0.00);// total amount of the order (after discount) before taxes
            $table->decimal('shipping', 8, 2)->default(0.00);// shipping cost
            $table->decimal('total', 8, 2)->default(0.00);// subtotal + shipping + taxes (if any)
            $table->enum ('shipping_type', ['express', 'standard'])->default('standard');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->json('options')->nullable(); // JSON for extra stuff like sales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
