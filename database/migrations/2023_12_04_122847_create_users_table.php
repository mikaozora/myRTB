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
        Schema::create('users', function (Blueprint $table) {
            $table->string('NIP', 10)->nullable(false)->primary();
            $table->string('password', 100)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('class', 100)->nullable(false);
            $table->enum('gender', ['Male', 'Female'])->nullable(false);
            $table->string('room_number', 10)->nullable(false);
            $table->string('phone_number', 20)->nullable(false);
            $table->string('photo')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
