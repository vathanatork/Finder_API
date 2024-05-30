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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('university_id');
            $table->string('name_en');
            $table->string('name_kh');
            $table->string('image_url')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_kh')->nullable();
            $table->unsignedBigInteger('contact_info_id')->nullable();
            $table->string('apply_link')->nullable();
            $table->text('required_document_en')->nullable();
            $table->text('required_document_kh')->nullable();
            $table->text('apply_process_en')->nullable();
            $table->text('apply_process_kh')->nullable();
            $table->mediumText('other_en')->nullable();
            $table->mediumText('other_kh')->nullable();
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
        Schema::dropIfExists('scholarships');
    }
};
