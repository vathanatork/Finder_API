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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_kh');
            $table->string('image');
            $table->string('logo');
            $table->integer('yearly_income');
            $table->unsignedBigInteger('common_degree_level');
            $table->decimal('job_growth_rate',5,2)->nullable();
            $table->mediumText('job_do_en')->nullable();
            $table->mediumText('job_do_kh')->nullable();
            $table->mediumText('earning_en')->nullable();
            $table->mediumText('earning_kh')->nullable();
            $table->mediumText('job_outlook_en')->nullable();
            $table->mediumText('job_outlook_kh')->nullable();
            $table->mediumText('task_en')->nullable();
            $table->mediumText('task_kh')->nullable();
            $table->mediumText('knowledge_en')->nullable();
            $table->mediumText('knowledge_kh')->nullable();
            $table->mediumText('skill_en')->nullable();
            $table->mediumText('skill_kh')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
