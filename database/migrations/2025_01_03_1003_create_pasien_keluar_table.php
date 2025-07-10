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
        Schema::create('pasien_keluar', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_pasien_masuk')->autoIncrement(false);
            $table->dateTime('waktu_keluar');
            $table->string('cara_keluar');
            $table->unsignedBigInteger('fk_id_logs')->index('pasien_keluar_fk_id_logs_foreign');
            $table->timestamps();

            // Foreign key to pasien_masuk
            $table->foreign('fk_id_pasien_masuk')->references('id_pasien_masuk')->on('pasien_masuk')->onDelete('cascade');

            // Foreign key to logs
            $table->foreign('fk_id_logs')->references('id_logs')->on('logs_tabel_pasien')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_keluar');
    }
};
