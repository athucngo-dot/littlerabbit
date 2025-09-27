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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // For logged-in users
            $table->foreignId('customer_id')
                  ->nullable() // allow null for guest users
                  ->constrained('customers')
                  ->cascadeOnDelete();
            $table->string('session_id')->nullable()->index();// for guest users
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
            $table->unsignedInteger('quantity')->default(1);
            $table->json('options')->nullable(); // optional extra data if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
