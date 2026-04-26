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
        Schema::create('shipping_details', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_user')->nullable(); // user id
            $table->string('shipping_recipient')->nullable(); // recipient name
            $table->string('shipping_street')->nullable(); // street
            $table->string('shipping_barrangay')->nullable(); // barangay
            $table->string('shipping_city')->nullable(); // city/municipality
            $table->string('shipping_province')->nullable(); // province
            $table->string('shipping_region')->nullable(); // region
            $table->string('shipping_zip')->nullable(); // zip code
            $table->string('shipping_contactNo')->nullable(); // contact number
            $table->text('shipping_address')->nullable(); // contains the combined address
            $table->string('shipping_isDefault')->nullable(); // indicate if this is the default address for the user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_details');
    }
};
