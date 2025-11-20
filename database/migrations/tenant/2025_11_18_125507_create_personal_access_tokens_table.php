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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->ulid('id', length: 32)->primary();
            $tokenableName = 'tokenable';
            $table
                ->string("{$tokenableName}_type")
                ->after($tokenableName);
            $table
                ->ulid("{$tokenableName}_id", 32)
                ->after("{$tokenableName}_type");

            $table->index(["{$tokenableName}_type", "{$tokenableName}_id"]);

            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
