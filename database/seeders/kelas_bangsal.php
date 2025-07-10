<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kelas_bangsal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas_bangsals = [
            // Bedah
            ['nama_kelas' => 'Melati 1', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 2', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 3', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 4', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 5', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 6', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 7', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'Melati 8', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'II B', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'II C', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'II D', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'III Pria', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'III Wanita', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'III Isolasi', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'III Anak', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 1],
            ['nama_kelas' => 'HCU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 1],

            
            // Anak
            ['nama_kelas' => 'IA', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'IB', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'IC', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'ID', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'IE', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'IIA', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'IIB', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'III A', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'III B', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 2],
            ['nama_kelas' => 'HCU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 2],

            // Kebidanan
            ['nama_kelas' => 'I', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 3],
            ['nama_kelas' => 'II', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 3],
            ['nama_kelas' => 'III obs', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 3],
            ['nama_kelas' => 'III gyn', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 3],
            ['nama_kelas' => 'HCU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 3],
            ['nama_kelas' => 'VK', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 3],

            // Paviliun Nantongga
            // Paviliun Nantongga - Lili
            ['nama_kelas' => 'Lili 1', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Lili 2', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Lili 3', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Lili 4', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Lili 5', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Lili 7', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 4],

            // Paviliun Nantongga - Anggrek
            ['nama_kelas' => 'Anggrek 1', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 2', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 3', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 4', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 5', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 6', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Anggrek 7', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],

            // Paviliun Nantongga - Bougenville
            ['nama_kelas' => 'Bougenville 1', 'jenis_kelas' => 'VIP', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],
            ['nama_kelas' => 'Bougenville 2', 'jenis_kelas' => 'VIP', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 4],

            // Indera
            ['nama_kelas' => 'II', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 5],
            ['nama_kelas' => 'III', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 5],

            // Paru
            ['nama_kelas' => 'III Pria', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 6],
            ['nama_kelas' => 'III Wanita', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 6],
            ['nama_kelas' => 'Isolasi SO', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 6],
            ['nama_kelas' => 'Isolasi RO', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 6],

            // Jantung
            ['nama_kelas' => 'I A', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 7],
            ['nama_kelas' => 'I B', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 7],
            ['nama_kelas' => 'II', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 7],
            ['nama_kelas' => 'III A', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 7],
            ['nama_kelas' => 'III B', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 7],

            // Neurologi
            ['nama_kelas' => 'I', 'jenis_kelas' => 'Kelas 1', 'jumlah_tempat_tidur' => 1, 'fk_kd_bangsal' => 8],
            ['nama_kelas' => 'II A', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 8],
            ['nama_kelas' => 'II B', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 8],
            ['nama_kelas' => 'III A', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 8],
            ['nama_kelas' => 'III B', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 8],
            ['nama_kelas' => 'HCU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 8],

            // Interne
            ['nama_kelas' => 'II A', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'II B', 'jenis_kelas' => 'Kelas 2', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'III W 1', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'III W 2', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'III W 3', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'III P 1', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 3, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'III P 2', 'jenis_kelas' => 'Kelas 3', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 9],
            ['nama_kelas' => 'HCU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 6, 'fk_kd_bangsal' => 9],

            // ICU
            ['nama_kelas' => 'ICU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 12, 'fk_kd_bangsal' => 10],

            // NICU
            ['nama_kelas' => 'NICU', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 8, 'fk_kd_bangsal' => 11],

            // Perinatologi
            ['nama_kelas' => 'Perinatologi', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 4, 'fk_kd_bangsal' => 12],

            // Observasi Bayi
            ['nama_kelas' => 'Observasi Bayi', 'jenis_kelas' => '-', 'jumlah_tempat_tidur' => 2, 'fk_kd_bangsal' => 13],
            
        ];

        DB::table('kelas_bangsal')->insert($kelas_bangsals);
    }
}
