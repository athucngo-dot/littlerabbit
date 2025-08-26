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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');
            $table->tinyInteger ('rv_rate')->default(5);
            $table->text('rv_comment')->nullable();
            $table->tinyInteger ('rv_quality')->default(5);
            $table->tinyInteger ('rv_comfort')->default(5);
            $table->tinyInteger ('rv_size')->default(5);
            $table->tinyInteger ('rv_delivery')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
