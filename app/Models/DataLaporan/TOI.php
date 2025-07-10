<?php

namespace App\Models\DataLaporan;

use Illuminate\Database\Eloquent\Model;

class TOI extends Model
{
    // Rumus TOI (Turn Over Interval)
    // TOI = ((Jumlah_tempat_tidur_tersedia-rata2_per-periode(jumlah_tempat_tidur_terpakai)) x periode) / jumlah_pasien_keluar (per periode)
}
