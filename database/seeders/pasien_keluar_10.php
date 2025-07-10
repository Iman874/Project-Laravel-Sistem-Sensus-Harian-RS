<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class pasien_keluar_10 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perulangan 50 data pasien
        $index = 70;

        // Buat data log dummy 20 buah (auto increment)
        for ($i = 1; $i <= 10; $i++) {
            $logs = [
                'action' => now(),
                'role' => 'Developer',
                'id_role' => 1,
            ];
            DB::table('logs_tabel_pasien')->insert($logs);
        }

        //Ambil data pasien masuk yang tidak pernah pindah
        $pasien_masuk = DB::table('pasien_masuk')
            ->leftJoin('pasien_pindah', 'pasien_masuk.id_pasien_masuk', '=', 'pasien_pindah.fk_id_pasien_masuk')
            ->whereNull('pasien_pindah.fk_id_pasien_masuk')
            ->get();

        //Ambil data pasien masuk yang pernah pindah
        $pasien_masuk_pindah = DB::table('pasien_masuk')
            ->join('pasien_pindah', 'pasien_masuk.id_pasien_masuk', '=', 'pasien_pindah.fk_id_pasien_masuk')
            ->get();

        // Kelauarkan 5 pasien dari pasien_masuk yang tidak pernah pindah
        for ($i = 0; $i < 5; $i++) {
            $pasien_keluar = [
                'fk_id_pasien_masuk' => $pasien_masuk[$i]->id_pasien_masuk,
                'waktu_keluar' => now(),
                'cara_keluar' => ['hidup', 'mati', 'dipindahkan'][array_rand(['hidup', 'mati', 'dipindahkan'])],
                'fk_id_logs' => $index++,
            ];
            DB::table('pasien_keluar')->insert($pasien_keluar);
        }

        // Keluarkan 5 pasien dari pasien_masuk yang pernah pindah
        for ($i = 0; $i < 5; $i++) {
            $pasien_keluar = [
                'fk_id_pasien_masuk' => $pasien_masuk_pindah[$i]->id_pasien_masuk,
                'waktu_keluar' => now(),
                'cara_keluar' => ['hidup', 'mati', 'dipindahkan'][array_rand(['hidup', 'mati', 'dipindahkan'])],
                'fk_id_logs' => $index++,
            ];
            DB::table('pasien_keluar')->insert($pasien_keluar);
        }
    }
}
