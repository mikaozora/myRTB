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
        Schema::create('banned_users', function (Blueprint $table) {
            $table->uuid('banned_id')->nullable(false)->primary();
            $table->string('NIP', 10)->nullable(false);
            $table->enum('type', ['machine', 'kitchen', 'co-working space', 'serbaguna', 'theater'])->nullable(false);
            $table->timestamp('end_time')->nullable(false);
            $table->timestamps();

            $table->foreign('NIP')->on('users')->references('NIP')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_users');
    }
};
