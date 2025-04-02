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
        Schema::create('shipment_methods', function (Blueprint $table) {
            $table->tinyInteger('shipment_method_id', true)->primary();
            $table->text('image');
            $table->string('name', 100)->unique()->nullable(false);
            $table->decimal('price', 8,2);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_methods');
    }
};
