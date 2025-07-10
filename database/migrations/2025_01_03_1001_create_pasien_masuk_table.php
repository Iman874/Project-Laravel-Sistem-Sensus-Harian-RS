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
        Schema::create('pasien_masuk', function (Blueprint $table) {
            $table->bigIncrements('id_pasien_masuk');
            $table->string('no_rm');
            $table->string('nama_pasien');
            $table->string('jenis_kelamin');
            $table->dateTime('waktu_masuk');
            $table->unsignedBigInteger('fk_id_logs')->index('pasien_masuk_fk_id_logs_foreign');
            $table->unsignedBigInteger('fk_kd_bangsal')->index('pasien_masuk_fk_kd_bangsal_foreign');
            $table->unsignedBigInteger('fk_id_kelas')->index('pasien_masuk_fk_id_kelas_foreign');
            $table->timestamps();

            // Foreign key to logs
            $table->foreign('fk_id_logs')->references('id_logs')->on('logs_tabel_pasien')->onDelete('no action');

            // Foreign key to bangsal
            $table->foreign('fk_kd_bangsal')->references('kd_bangsal')->on('bangsal')->onDelete('no action');

            // Foreign key to kelas_bangsal
            $table->foreign('fk_id_kelas')->references('id_kelas')->on('kelas_bangsal')->onDelete('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_masuk');
    }
};
