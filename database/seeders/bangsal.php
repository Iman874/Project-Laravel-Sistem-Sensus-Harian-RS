<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bangsal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bangsals = [
            ['nama_bangsal' => 'Bedah'],
            ['nama_bangsal' => 'Anak'],
            ['nama_bangsal' => 'Kebidanan'],
            ['nama_bangsal' => 'Paviliun Nantongga'],
            ['nama_bangsal' => 'Indera'],
            ['nama_bangsal' => 'Paru'],
            ['nama_bangsal' => 'Jantung'],
            ['nama_bangsal' => 'Neurologi'],
            ['nama_bangsal' => 'Interne'],
            ['nama_bangsal' => 'ICU'],
            ['nama_bangsal' => 'NICU'],
            ['nama_bangsal' => 'Perinatologi'],
            ['nama_bangsal' => 'Observasi Bayi'],
        ];

        DB::table('bangsal')->insert($bangsals);
    }
}
