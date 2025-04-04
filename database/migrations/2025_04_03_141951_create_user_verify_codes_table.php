<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_verify_codes', function (Blueprint $table) {
            $table->id('user_verify_code_id')->primary();
            $table->smallInteger('user_id');
            $table->string('code', 6)->nullable(false);
//            $table->timestamp('expiry_at')->default(DB::raw('CURRENT_TIMESTAMP + INTERVAL 5 MINUTE'));
            $table->dateTime('expiry_at')->default(now()->addMinutes(5));
            $table->timestamps();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_verify_codes');
    }
};
