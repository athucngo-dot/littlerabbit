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
            $table->unsignedInteger('nb_of_items')->default(1);
            $table->enum ('gender', ['boy', 'girl', 'neutral'])->default('neutral');
            $table->boolean('is_active')->default(true);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('continue')->default(true);
            $table->foreignId('brand_id')
                  ->nullable()
                  ->constrained('brands')
                  ->onDelete('set null');
            $table->foreignId('material_id')
                  ->nullable()
                  ->constrained('materials')
                  ->onDelete('set null');
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
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
