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
        Schema::create('pasien_pindah', function (Blueprint $table) {
            $table->bigIncrements('id_pindah');
            $table->unsignedBigInteger('fk_id_pasien_masuk')->index('pasien_pindah_fk_id_pasien_masuk_foreign');
            $table->unsignedBigInteger('fk_asal_bangsal')->index('pasien_pindah_fk_asal_bangsal_foreign');
            $table->unsignedBigInteger('fk_tujuan_bangsal')->index('pasien_pindah_fk_tujuan_bangsal_foreign');
            $table->unsignedBigInteger('fk_id_kelas_asal')->index('pasien_pindah_fk_id_kelas_asal_foreign');
            $table->unsignedBigInteger('fk_id_kelas_tujuan')->nullable()->index('pasien_pindah_fk_id_kelas_tujuan_foreign');
            $table->dateTime('waktu_pindah');
            $table->unsignedBigInteger('fk_id_logs')->index('pasien_pindah_fk_id_logs_foreign');
            $table->timestamps();

            // Foreign key to pasien_masuk
            $table->foreign('fk_id_pasien_masuk')->references('id_pasien_masuk')->on('pasien_masuk')->onDelete('cascade');

            // Foreign key to bangsal asal
            $table->foreign('fk_asal_bangsal')->references('kd_bangsal')->on('bangsal')->onDelete('cascade');

            // Foreign key to bangsal tujuan
            $table->foreign('fk_tujuan_bangsal')->references('kd_bangsal')->on('bangsal')->onDelete('cascade');

            // Foreign key to kelas_bangsal asal
            $table->foreign('fk_id_kelas_asal')->references('id_kelas')->on('kelas_bangsal')->onDelete('cascade');

            // Foreign key to kelas_bangsal tujuan
            $table->foreign('fk_id_kelas_tujuan')->references('id_kelas')->on('kelas_bangsal')->onDelete('cascade');

            // Foreign key to logs
            $table->foreign('fk_id_logs')->references('id_logs')->on('logs_tabel_pasien')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_pindah');
    }
};
