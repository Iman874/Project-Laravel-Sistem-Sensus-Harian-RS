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
        Schema::create('kelas_bangsal', function (Blueprint $table) {
            $table->bigIncrements('id_kelas');
            $table->string('nama_kelas');
            $table->string('jenis_kelas')->nullable();
            $table->integer('jumlah_tempat_tidur');
            $table->unsignedBigInteger('fk_kd_bangsal');
            $table->timestamps();

            // Foreign key to bangsal
            $table->foreign('fk_kd_bangsal')->references('kd_bangsal')->on('bangsal')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_bangsal');
    }
};
