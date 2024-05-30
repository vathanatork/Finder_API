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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('university_id');
            $table->string('name_kh')->nullable();
            $table->string('name_en')->nullable();
            $table->string('image_url')->nullable();
            $table->date('date');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('contact_info_id')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_kh')->nullable();
            $table->unsignedBigInteger('adr_province_id')->nullable();
            $table->unsignedBigInteger('adr_district_id')->nullable();
            $table->unsignedBigInteger('adr_commune_id')->nullable();
            $table->unsignedBigInteger('adr_village_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
