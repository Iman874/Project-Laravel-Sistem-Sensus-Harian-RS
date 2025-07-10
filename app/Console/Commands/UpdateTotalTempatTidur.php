<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateTotalTempatTidur extends Command
{
    /**
     * Nama dan deskripsi command.
     */
    protected $signature = 'update:total_tempat_tidur';
    protected $description = 'Menjumlahkan ulang jumlah_tempat_tidur dari kelas_bangsal ke total_tempat_tidur di bangsal';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        // Ambil semua bangsal yang ada
        $bangsals = DB::table('bangsal')->get();

        foreach ($bangsals as $bangsal) {
            // Hitung total tempat tidur dari kelas_bangsal berdasarkan fk_kd_bangsal
            $total = DB::table('kelas_bangsal')
                ->where('fk_kd_bangsal', $bangsal->kd_bangsal)
                ->sum('jumlah_tempat_tidur');

            // Update total_tempat_tidur di tabel bangsal
            DB::table('bangsal')
                ->where('kd_bangsal', $bangsal->kd_bangsal)
                ->update(['total_tempat_tidur' => $total]);

            $this->info("Bangsal '{$bangsal->nama_bangsal}' diperbarui: Total tempat tidur = {$total}");
        }

        $this->info("Update total tempat tidur selesai!");
    }
}
