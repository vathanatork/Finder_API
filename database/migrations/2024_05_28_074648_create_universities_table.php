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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_image');
            $table->string('image');
            $table->text('description');
            $table->unsignedBigInteger('university_type_id');
            $table->integer('established_year');
            $table->integer('ranking')->nullable();
            $table->unsignedBigInteger('contact_info_id')->nullable();
            $table->decimal('graduation_rate',5,2)->nullable();
            $table->decimal('average_tuition',10,2)->nullable();
            $table->decimal('average_study_year',10,2)->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('adr_province_id')->nullable();
            $table->unsignedBigInteger('adr_district_id')->nullable();
            $table->unsignedBigInteger('adr_commune_id')->nullable();
            $table->unsignedBigInteger('ard_village_id')->nullable();
            $table->boolean('is_active')->default(true);;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
