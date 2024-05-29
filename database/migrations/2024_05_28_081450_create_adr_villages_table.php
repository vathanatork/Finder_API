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
        Schema::create('adr_villages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adr_province_id');
            $table->unsignedBigInteger('adr_district_id');
            $table->unsignedBigInteger('adr_commune_id');

            $table->string('code',100)->nullable();
            $table->string('name_kh', 200);
            $table->string('name_en', 200);
            $table->string('reference')->nullable();

            $table->foreign('adr_province_id')
                ->references('id')
                ->on('adr_provinces')
                ->noActionOnDelete();

            $table->foreign('adr_district_id')
                ->references('id')
                ->on('adr_districts')
                ->noActionOnDelete();

            $table->foreign('adr_commune_id')
                ->references('id')
                ->on('adr_communes')
                ->noActionOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adr_villages');
    }
};
