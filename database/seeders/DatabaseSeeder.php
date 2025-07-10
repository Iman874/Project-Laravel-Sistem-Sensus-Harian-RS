<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ModelRSSeeder;
use Database\Seeders\bangsal;
use Database\Seeders\kelas_bangsal;
use Database\Seeders\pasien_masuk_50;
use Database\Seeders\pasien_pindah_20;
use Database\Seeders\pasien_keluar_10;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Peringatan data seeder ini hanya dapat work untuk database yang kosong
        // Jika database sudah terisi, maka akan terjadi error

        $this->call(RoleSeeder::class);
        $this->call(ModelRSSeeder::class);

        // buat bangsal
        $this->call(bangsal::class);
        $this->call(kelas_bangsal::class);

        // buat 50 data pasien masuk
        $this->call(pasien_masuk_50::class);

        // buat 20 data pasien pindah
        $this->call(pasien_pindah_20::class);

        // buat 10 data pasien keluar
        $this->call(pasien_keluar_10::class);
    }
}
