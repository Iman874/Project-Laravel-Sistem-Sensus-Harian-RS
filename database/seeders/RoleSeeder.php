<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menambahkan Perawat
        DB::table('perawat')->insert([
            'username' => 'perawat1',
            'password' => Hash::make('12345678'),
            'nama' => 'Perawat Satu',
            'jenis_kelamin' => 'Laki-laki',
            'penempatan' => 'Paru',
            'role' => 'perawat'
        ]);

        // Menambahkan Petugas Indikator (Admin)
        DB::table('petugas_indikator')->insert([
            'username' => 'admin1',
            'password' => Hash::make('tes'),
            'nama' => 'Admin Satu',
            'id_petugas' => 1,
            'role' => 'petugas_indikator'
        ]);

        // Menambahkan Kepala Instalasi
        DB::table('kepala_instalasi')->insert([
            'username' => 'kepala1',
            'password' => Hash::make('tes'),
            'nama' => 'Kepala Satu',
            'gelar' => 'Dr.',
            'id_kepala_instalasi' => 1,
            'role' => 'kepala_instalasi'
        ]);
    }
}
