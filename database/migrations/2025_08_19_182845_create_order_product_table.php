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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();
            $table->foreignId('color_id')
                  ->nullable()
                  ->constrained('colors')
                  ->nullOnDelete();
            $table->foreignId('size_id')
                  ->nullable()
                  ->constrained('sizes')
                  ->nullOnDelete();
            $table->unsignedInteger('nb_of_items')->default(1);// number of items of this product (1 product can have multiple items)
            $table->decimal('price', 8, 2)->default(0.00);// price at the time of order (in case of discounts later)
            $table->unsignedInteger('quantity')->default(1);// quantity of this product in the order
            $table->json('options')->nullable(); // JSON for extra stuff like sales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_products');
    }
};
