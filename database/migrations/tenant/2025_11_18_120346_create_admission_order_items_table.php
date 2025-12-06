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
        Schema::create('admission_order_items', function (Blueprint $table) {
            $table->ulid('id', length: 32)->primary();
            $table->string('admission_order_id', length: 32);
            $table->longText('order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admission_id')->references('id')->on('admissions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_order_items');
    }
};
