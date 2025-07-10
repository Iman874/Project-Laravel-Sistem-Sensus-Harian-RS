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
        Schema::create('petugas_indikator', function (Blueprint $table) {
            $table->unsignedBigInteger('id_petugas')->default(1);
            $table->string('username')->default('admin')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('role')->default('petugas_indikator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas_indikator');
    }
};
