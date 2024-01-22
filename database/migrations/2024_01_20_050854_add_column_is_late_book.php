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
        Schema::table('book_kitchens', function (Blueprint $table) {
            $table->enum("is_late",[0,1])->nullable(true)->default(null);
        });
        Schema::table('book_machines', function (Blueprint $table) {
            $table->enum("is_late",[0,1])->nullable(true)->default(null);
        });
        Schema::table('book_rooms', function (Blueprint $table) {
            $table->enum("is_late",[0,1])->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_kitchens', function (Blueprint $table) {
            $table->dropColumn("is_late");
        });
        Schema::table('book_machines', function (Blueprint $table) {
            $table->dropColumn("is_late");
        });
        Schema::table('book_rooms', function (Blueprint $table) {
            $table->dropColumn("is_late");
        });
    }
};
