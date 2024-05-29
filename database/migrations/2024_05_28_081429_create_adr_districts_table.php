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
        Schema::create('adr_districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adr_province_id');

            $table->string('code',100)->nullable();
            $table->string('name_kh', 200);
            $table->string('name_en', 200);
            $table->enum('type', ['Municipality','Khan','District'])->default('District');
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
        Schema::dropIfExists('adr_districts');
    }
};
