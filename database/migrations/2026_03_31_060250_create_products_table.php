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
            $table->string('product_name')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_salePrice')->nullable();
            $table->string('product_quantity')->nullable();
            $table->string('product_soldCount')->nullable();
            $table->string('product_rating')->nullable();
            $table->string('product_thumbnail')->nullable();
            $table->text('product_images')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_category')->nullable();
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
