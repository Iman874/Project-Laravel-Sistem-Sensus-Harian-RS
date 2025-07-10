<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JumlahTempatTidur;

class pasien_masuk_50 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perulangan 50 data pasien
        $index = 1;
        $no_rm = 300; // Nomor rekam medis awal

        // Buat data log dummy 50 buah
        for ($i = 1; $i <= 50; $i++) {
            $logs = [
                'action' => now(),
                'role' => 'Developer',
                'id_role' => 1,
            ];
            DB::table('logs_tabel_pasien')->insert($logs);
        }

        // Fungsi untuk mendapatkan daftar kelas yang tersedia
        function getKelasTersedia($kd_bangsal, $kelasSemua) {
            $kelasTersedia = [];

            foreach ($kelasSemua as $id_kelas) {
                $tempatTidur = new JumlahTempatTidur($kd_bangsal, $id_kelas);
                if ($tempatTidur->tempatTidurTersedia > 0) {
                    $kelasTersedia[] = $id_kelas;
                }
            }

            return $kelasTersedia;
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
        ];

        // Jumlah pasien per bangsal
        $jumlahPasienPerBangsal = [
            1 => 10, // Bedah
            2 => 5, // Anak
            3 => 5, // Kebidanan
            4 => 10, // Paviliun Nantongga
            5 => 10, // Indera
            6 => 5, // Paru
            7 => 5, // Jantung
        ];

        foreach ($bangsalKelas as $kd_bangsal => $kelasId) {
            shuffle($kelasId); // Acak urutan angka

            for ($i = 1; $i <= $jumlahPasienPerBangsal[$kd_bangsal]; $i++) {
                $kelasTersedia = getKelasTersedia($kd_bangsal, $kelasId);

                if (empty($kelasTersedia)) {
                    // Jika tidak ada kelas yang tersedia, hentikan perulangan
                    break;
                }

                shuffle($kelasTersedia); // Acak daftar kelas yang tersedia
                $kelasTerpilih = $kelasTersedia[array_rand($kelasTersedia)]; // Pilih salah satu kelas yang tersedia

                $pasien_masuk = [
                    'no_rm' => $no_rm++, // Nomor rekam medis bertambah
                    'nama_pasien' => 'Pasien ' . $kd_bangsal . ' ' . $i,
                    'jenis_kelamin' => ['Laki-laki', 'Perempuan'][array_rand(['Laki-laki', 'Perempuan'])], // Acak gender
                    'waktu_masuk' => now(),
                    'fk_id_kelas' => $kelasTerpilih, // Kelas yang dipilih dari yang tersedia
                    'fk_kd_bangsal' => $kd_bangsal, // Kode bangsal
                    'fk_id_logs' => $index++,
                ];
                DB::table('pasien_masuk')->insert($pasien_masuk);
            }
        }
    }
}
