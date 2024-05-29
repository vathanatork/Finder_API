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
        Schema::create('adr_provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->string('name_kh', 200);
            $table->string('name_en', 200);
            $table->enum('type', ['Province','Capital'])->default('Province');
            $table->string('reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adr_provinces');
    }
};
