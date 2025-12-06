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
        Schema::create('patient_allergies', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('patient_id', length: 30);
            $table->string('type', length: 50);
            $table->string('name');
            $table->string('code', length: 50)->nullable();
            $table->string(column: 'severity', length: 50);
            $table->text(column: 'symptoms');
            $table->string('clinical_status', length: 50);
            $table->string('verification_status', length: 50)->nullable();
            $table->date('onset_date');
            $table->date('last_occurrence_date');
            $table->text(column: 'notes')->nullable();
            $table->string('documented_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_allergies');
    }
};
