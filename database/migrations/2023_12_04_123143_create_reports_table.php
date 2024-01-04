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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('report_id')->nullable(false)->primary();
            $table->string('NIP', 10)->nullable(false);
            $table->enum('type', ['Public Facility', 'Room'])->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('photo')->nullable(false);
            $table->uuid('status_id')->nullable(false);

            $table->foreign('NIP')->on('users')->references('NIP')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->on('status')->references('status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
