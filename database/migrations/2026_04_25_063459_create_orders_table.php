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
            $table->string('order_reference')->nullable();
            $table->string('order_userId')->nullable();
            $table->text('order_products')->nullable();
            $table->string('order_total')->nullable();
            $table->string('order_shippingMethod')->nullable();
            $table->string('order_shippingAddress')->nullable();
            $table->string('order_shippingReceipt')->nullable();
            $table->string('order_shippingFee')->nullable();
            $table->string('order_purchaseReceipt')->nullable();
            $table->string('order_status')->nullable();
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
