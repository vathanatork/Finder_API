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
        Schema::table('events', function (Blueprint $table) {
            $table->mediumText('description_en')->nullable()->change();
            $table->mediumText('description_kh')->nullable()->change();
            $table->unsignedBigInteger('event_category_id');
            $table->string('thumbnail_image');
            $table->date('event_date');
            $table->string('location');
            $table->string('location_link');
            $table->softDeletes();
            $table->dropColumn('image_url');
            $table->dropColumn('date');
            $table->dropColumn('address');
            $table->dropColumn('contact_info_id');
            $table->dropColumn('adr_province_id');
            $table->dropColumn('adr_district_id');
            $table->dropColumn('adr_commune_id');
            $table->dropColumn('adr_village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('description_en')->nullable()->change();
            $table->text('description_kh')->nullable()->change();
            $table->dropColumn('event_category_id');
            $table->dropColumn('thumbnail_image');
            $table->dropColumn('event_date');
            $table->dropColumn('location');
            $table->dropColumn('location_link');
            $table->string('image_url');
            $table->date('date');
            $table->string('address');
            $table->unsignedBigInteger('contact_info_id');
            $table->unsignedBigInteger('adr_province_id');
            $table->unsignedBigInteger('adr_district_id');
            $table->unsignedBigInteger('adr_commune_id');
            $table->unsignedBigInteger('adr_village_id');
        });
    }
};
