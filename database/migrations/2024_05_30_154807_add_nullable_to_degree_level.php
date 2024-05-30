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
        Schema::table('degree_levels', function (Blueprint $table) {
            $table->string('description_en')->nullable()->change();
            $table->string('description_kh')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('degree_levels', function (Blueprint $table) {
            $table->string('description_en')->nullable(false)->change();
            $table->string('description_kh')->nullable(false)->change();
        });
    }
};
