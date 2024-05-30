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
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('institute_id')->nullable();
            $table->unsignedBigInteger('university_id')->nullable();
            $table->unsignedBigInteger('major_name_id');
            $table->text('description_en')->nullable();
            $table->text('description_kh')->nullable();
            $table->decimal('tuition',10,2)->nullable();
            $table->decimal('study_duration',5,1)->nullable();
            $table->string('future_career_en')->nullable();
            $table->string('future_career_kh')->nullable();
            $table->integer('student_number')->nullable();
            $table->decimal('required_credit',5,2)->nullable();
            $table->string('curriculum_url')->nullable();
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
        Schema::dropIfExists('majors');
    }
};
