<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
//    public function up(): void
//    {
//        // Use raw SQL to rename the column
//        DB::statement('ALTER TABLE university_types CHANGE COLUMN name name_en VARCHAR(255)');
//
//        Schema::table('university_types', function (Blueprint $table) {
//            $table->string('name_kh')->after('name_en')->nullable();
//        });
//    }
//
//    /**
//     * Reverse the migrations.
//     */
//    public function down(): void
//    {
//        // Drop the new column added during the migration
//        Schema::table('university_types', function (Blueprint $table) {
//            $table->dropColumn('name_kh');
//        });
//
//        // Use raw SQL to rename the column back
//        DB::statement('ALTER TABLE university_types CHANGE COLUMN name_en name VARCHAR(255)');
//    }
};
