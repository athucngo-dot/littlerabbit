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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('nb_of_items')->default(1); // number of items in the product (e.g., pack of 3)
            $table->enum ('gender', ['boy', 'girl', 'unisex'])->default('unisex');
            $table->boolean('is_active')->default(true);
            $table->boolean('new_arrival')->default(false);
            $table->unsignedTinyInteger('homepage_promo')->default(0);
            $table->boolean('continue')->default(true);
            $table->foreignId('brand_id')
                  ->nullable()
                  ->constrained('brands')
                  ->nullOnDelete();
            $table->foreignId('material_id')
                  ->nullable()
                  ->constrained('materials')
                  ->nullOnDelete();
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
