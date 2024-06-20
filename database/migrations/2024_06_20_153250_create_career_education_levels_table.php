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
        Schema::create('career_education_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('degree_level_id');
            $table->unsignedBigInteger('career_id');
            $table->decimal('percentage',5,2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_education_levels');
    }
};
