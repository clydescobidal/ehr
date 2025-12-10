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
        Schema::create('patient_immunizations', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('patient_id', length: 30);
            $table->string('vaccine_name');
            $table->date('administration_date');
            $table->integer('dose_number');
            $table->string('route', 50);
            $table->string('administered_by')->nullable();
            $table->string('facility_name')->nullable();
            $table->string('status', 50)->nullable();
            $table->text('reaction_details')->nullable();
            $table->notes('reaction_details')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_immunizations');
    }
};
