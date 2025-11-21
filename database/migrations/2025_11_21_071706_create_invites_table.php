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
        Schema::create('invites', function (Blueprint $table) {
            $table->ulid('id', length: 30)->primary();
            $table->ulid('tenant_id', length: 30);
            $table->ulid('role_id', length: 30);
            $table->string('email');
            $table->string('token');
            $table->timestamps();

            $table->unique(['tenant_id', 'role_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
