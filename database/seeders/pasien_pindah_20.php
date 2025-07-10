<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JumlahTempatTidur;

class pasien_pindah_20 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perulangan 20 data pasien
        $index = 50;

        // Buat data log dummy 50 buah
        for ($i = 1; $i <= 20; $i++) {
            $logs = [
                'action' => now(),
                'role' => 'Developer',
                'id_role' => 1,
            ];
            DB::table('logs_tabel_pasien')->insert($logs);
        }

        // Daftar bangsal dan kelas
        $bangsalKelas = [
            1 => range(1, 16), // Bedah
            2 => range(17, 26), // Anak
            3 => range(27, 32), // Kebidanan
            4 => range(33, 47), // Paviliun Nantongga
            5 => range(48, 49), // Indera
            6 => range(50, 53), // Paru
            7 => range(54, 58), // Jantung
            8 => range(59, 64), // Neurologi
            9 => range(65, 72), // Interne
        ];

        // Fungsi untuk mendapatkan daftar kelas yang tersedia
        function getKelasTersedia_pindah($kd_bangsal, $kelasSemua) {
            $kelasTersedia = [];

            foreach ($kelasSemua as $id_kelas) {
                $tempatTidur = new JumlahTempatTidur($kd_bangsal, $id_kelas);
                if ($tempatTidur->tempatTidurTersedia > 0) {
                    $kelasTersedia[] = $id_kelas;
                }
            }

            return $kelasTersedia;
        }

        // Ambil data pasien masuk dari setiap bangsal
        $pasien_masuk = [];
        foreach ($bangsalKelas as $kd_bangsal => $kelasId) {
            $pasien_masuk[$kd_bangsal] = DB::table('pasien_masuk')
                ->where('fk_kd_bangsal', $kd_bangsal)
                ->get();
        }

        // Daftar pasien pindah
        $pasien_pindah_data = [
            ['asal' => 1, 'tujuan' => 9, 'jumlah' => 4], // Bedah ke Interne
            ['asal' => 2, 'tujuan' => 8, 'jumlah' => 3], // Anak ke Neurologi
            ['asal' => 3, 'tujuan' => 7, 'jumlah' => 3], // Kebidanan ke Jantung
            ['asal' => 4, 'tujuan' => 6, 'jumlah' => 5], // Paviliun Nantongga ke Paru
            ['asal' => 5, 'tujuan' => 1, 'jumlah' => 5], // Indera ke Bedah
        ];

        // Perulangan untuk memindahkan pasien
        $index = 50;
        foreach ($pasien_pindah_data as $data) {
            for ($i = 0; $i < $data['jumlah']; $i++) {
                $kelasTersedia = getKelasTersedia_pindah($data['tujuan'], $bangsalKelas[$data['tujuan']]);
                shuffle($kelasTersedia);
                $kelasTerpilih = $kelasTersedia[array_rand($kelasTersedia)];

                $pasien_pindah = [
                    'fk_id_pasien_masuk' => $pasien_masuk[$data['asal']][$i]->id_pasien_masuk,
                    'fk_asal_bangsal' => $data['asal'],
                    'fk_tujuan_bangsal' => $data['tujuan'],
                    'fk_id_kelas_asal' => $pasien_masuk[$data['asal']][$i]->fk_id_kelas,
                    'fk_id_kelas_tujuan' => $kelasTerpilih,
                    'waktu_pindah' => now(),
                    'fk_id_logs' => $index++,
                ];
                DB::table('pasien_pindah')->insert($pasien_pindah);
            }
        }
    }
}
