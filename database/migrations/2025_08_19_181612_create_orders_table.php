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
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();
            $table->enum ('status', ['pending', 'paid', 'shipping', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('total', 8, 2)->default(0.00);// total amount of the order after discounts and taxes
            $table->enum ('shipping_type', ['express', 'standard'])->default('standard');
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
