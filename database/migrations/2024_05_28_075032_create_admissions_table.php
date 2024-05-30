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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('major_id')->nullable();
            $table->text('admission_requirements_en')->nullable();
            $table->text('admission_requirements_kh')->nullable();
            $table->integer('average_student_acceptance')->nullable();
            $table->date('application_deadline')->nullable();
            $table->text('admission_process_en')->nullable();
            $table->unsignedBigInteger('contact_info_id')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_kh')->nullable();
            $table->string('admission_url')->nullable();
            $table->text('other_en')->nullable();
            $table->text('other_kh')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
