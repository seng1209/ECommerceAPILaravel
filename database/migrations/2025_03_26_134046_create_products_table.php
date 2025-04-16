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
            $table->id('product_id')->primary();
            $table->text('image');
            $table->text('image_name');
            $table->string('product_name', 100)->unique()->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->tinyInteger('brand_id')->nullable(false);
            $table->tinyInteger('category_id')->nullable(false);
            $table->text('description');
            $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
