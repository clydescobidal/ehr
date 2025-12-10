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
        Schema::create('patient_medications', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('patient_id', length: 30);
            $table->string('medication_name');
            $table->string('dosage', 100);
            $table->string('frequency', 100);
            $table->string('route', 50);
            $table->text('instructions');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('medication_status', 50);
            $table->text('discontinuation_reason')->nullable();
            $table->string('prescribed_by')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medications');
    }
};
