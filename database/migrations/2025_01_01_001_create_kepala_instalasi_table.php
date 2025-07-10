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
        Schema::create('kepala_instalasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kepala_instalasi')->default(1);
            $table->string('username')->default('kepala_instalasi')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('gelar');
            $table->string('role')->default('kepala_instalasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepala_instalasi');
    }
};
