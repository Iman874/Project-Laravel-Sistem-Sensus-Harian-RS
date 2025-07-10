<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModelRSSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            DB::table('model_rs')->insert([
                'tanggal' => Carbon::now()->subDays(30 - $i)->format('Y-m-d'),
                'BOR' => rand(40, 90),  // Persentase 40% - 90%
                'LOS' => rand(2, 10),   // Hari antara 2 - 10
                'TOI' => rand(1, 5),    // Hari antara 1 - 5
                'BTO' => rand(10, 50),  // Kali antara 10 - 50
            ]);
        }
    }
}
