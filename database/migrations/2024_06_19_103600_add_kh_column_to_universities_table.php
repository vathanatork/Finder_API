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
        Schema::table('universities', function (Blueprint $table) {
            $table->renameColumn('name', 'name_en');
            $table->string('name_kh')->nullable();
            $table->renameColumn('description', 'description_en');
            $table->text('description_kh')->nullable();
            $table->renameColumn('address','address_en');
            $table->string('address_kh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->renameColumn('name_en', 'name');
            $table->dropColumn('name_kh');
            $table->renameColumn('description_en', 'description');
            $table->dropColumn('description_en');
            $table->renameColumn('address_en','address');
            $table->dropColumn('address_kh');
        });
    }
};
