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
        Schema::create('patient_medical_conditions', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('patient_id', length: 30);
            $table->string('condition_code', length: 50);
            $table->string('condition_description', length: 50);
            $table->string('severity', length: 50);
            $table->string('clinical_status', length: 50);
            $table->string('verification_status', length: 50)->nullable();
            $table->date('onset_date');
            $table->date('diagnosed_date');
            $table->date('resolved_date')->nullable();
            $table->string('diagnosed_by')->nullable();
            $table->text(column: 'notes')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medical_conditions');
    }
};
