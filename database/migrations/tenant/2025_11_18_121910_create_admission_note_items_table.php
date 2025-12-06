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
        Schema::create('admission_note_items', function (Blueprint $table) {
            $table->ulid('id', length: 32)->primary();
            $table->string('admission_note_id', length: 32);
            $table->longText('note');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admission_note_id')->references('id')->on('admission_notes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_note_items');
    }
};
