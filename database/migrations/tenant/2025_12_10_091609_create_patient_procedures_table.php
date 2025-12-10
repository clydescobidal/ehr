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
        Schema::create('patient_procedures', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('patient_id', length: 30);
            $table->text('procedure_name');
            $table->string('procedure_category', 100);
            $table->string('body_site');
            $table->date('procedure_date');
            $table->dastringte('procedure_status', 100);
            $table->string('performed_by')->nullable();
            $table->string('facility_name')->nullable();
            $table->string('outcome', 50);
            $table->text('complications')->nullable();
            $table->text('indication')->nullable();
            $table->text('findings')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_procedures');
    }
};
