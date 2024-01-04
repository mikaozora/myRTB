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
        Schema::create('forums', function (Blueprint $table) {
            $table->uuid('message_id')->nullable(false)->primary();
            $table->string('NIP', 10)->nullable(false);
            $table->text('message')->nullable(false);
            $table->timestamp('created_at')->nullable(false)->useCurrent();

            $table->foreign('NIP')->on('users')->references('NIP')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
