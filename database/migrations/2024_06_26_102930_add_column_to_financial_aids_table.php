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
        Schema::table('financial_aids', function (Blueprint $table) {
            $table->unsignedBigInteger('university_id');
            $table->string('name_en');
            $table->string('name_kh');
            $table->string('image');
            $table->text('short_description_en');
            $table->text('short_description_kh');
            $table->mediumText('detail_description_en');
            $table->mediumText('detail_description_kh');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_aids', function (Blueprint $table) {
            $table->dropColumn('university_id');
            $table->dropColumn('name_en');
            $table->dropColumn('name_kh');
            $table->dropColumn('image');
            $table->dropColumn('short_description_en');
            $table->dropColumn('short_description_kh');
            $table->dropColumn('detail_description_en');
            $table->dropColumn('detail_description_kh');
            $table->dropColumn('is_active');
            $table->dropColumn('deleted_at');
        });
    }
};
