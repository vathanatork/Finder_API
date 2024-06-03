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
        Schema::table('admissions', function (Blueprint $table) {
            $table->decimal('application_fee',10,2)->nullable();
            $table->string('enroll_type_kh')->nullable();
            $table->string('enroll_type_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->dropColumn('application_fee');
            $table->dropColumn('enroll_type_kh');
            $table->dropColumn('enroll_type_en');
        });
    }
};
