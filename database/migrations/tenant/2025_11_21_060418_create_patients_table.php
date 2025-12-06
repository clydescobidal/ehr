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
        Schema::create('patients', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender',50);
            $table->string('biological_sex', 20);
            $table->string('marital_status', 50);
            $table->string('blood_type', 50);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address_line_1');
            $table->text('address_line_2');
            $table->string('address_barangay');
            $table->string('address_city');
            $table->string('address_province');
            $table->string('address_postal_code');
            $table->string('occupation');
            $table->string('religion');
            $table->text('contact_number');
            $table->date('deceased_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
