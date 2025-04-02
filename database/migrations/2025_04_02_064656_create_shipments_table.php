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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('shipment_id')->primary();
            $table->dateTime('shipment_date')->default((new DateTime())->format('Y-m-d H:i:s'));
            $table->tinyInteger('shipment_method_id');
            $table->smallInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->string('city', 30);
            $table->string('street_address', 60);
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shipment_method_id')->references('shipment_method_id')->on('shipment_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
