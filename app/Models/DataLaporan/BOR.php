<?php

namespace App\Models\DataLaporan;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataLaporan\BOR;
use App\Models\PasienKeluar;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BOR extends Model
{
    // Perhitungan BOR (Bed Occupancy Rate)
    // BOR = jumlah_hari_perawatan_per-periode / (totalTempatTidur * jumlah_per-periode)) * 100%;

    // Rumus untuk menghitung BOR
    public static function HitungBOR($jumlah_hari_perawatan, $totalTempatTidurBangsal, $jumlah_hari_per_periode)
    {
        if ($totalTempatTidurBangsal == 0 || empty($jumlah_hari_per_periode)) {
            return 0;
        }

        // Hitung jumlah hari dari array asosiatif
        $jumlah_hari = is_array($jumlah_hari_per_periode)
            ? array_reduce($jumlah_hari_per_periode, function ($carry, $item) {
                return $carry + $item['jumlah_hari'];
            }, 0) : $jumlah_hari_per_periode;

        if ($jumlah_hari == 0) {
            return 0;
        }
    
        return ($jumlah_hari_perawatan / ($totalTempatTidurBangsal * $jumlah_hari)) * 100;

    }
    
    public static function jumlahHariPerawatan($pasienMasuk, $pasienPindah, $pasienKeluar, $jumlah_hari_per_periode, $total_periode)
    {
        // Jika total periode adalah 0, kembalikan 0
        if ($total_periode == 0) {
            return 0;
        }
       
        // variabel untuk menyimpan jumlah hari perawatan per bangsal
        $jumlah_hari_perawatan = [];
        
        // Looping untuk setiap bangsal
        foreach ($pasienMasuk as $kdBangsal => $masukCollection) {
            // Jika tidak ada pasien masuk di bangsal ini, cek apakah ada pasien pindah atau keluar
            // Gabungkan semua collection per bulan menjadi satu collection untuk bangsal ini
            $gabunganMasuk = collect($masukCollection)->flatten();
            $gabunganKeluar = collect($pasienKeluar[$kdBangsal] ?? [])->flatten();
            $gabunganPindah = collect($pasienPindah[$kdBangsal] ?? [])->flatten();

            // Inisialisasi jumlah hari perawatan untuk bangsal ini
            $jumlah_hari = 0;
    
            // Ambil collection keluar dan pindah yang sesuai, cek apakah ada data
            $keluarCollection = collect($pasienKeluar[$kdBangsal] ?? [])->flatten();
            $pindahCollection = collect($pasienPindah[$kdBangsal] ?? [])->flatten();
            $masukCollection = collect($masukCollection)->flatten();
    
            // Looping untuk setiap pasien yang masuk di bangsal ini
            foreach ($masukCollection as $masuk) {
                $hari_pasien = 0;
    
                // Cari data keluar berdasarkan relasi
                $keluar = $keluarCollection->firstWhere('fk_id_pasien_masuk', $masuk->id_pasien_masuk);

                if ($keluar) {
                    $hari_pasien += Carbon::parse($keluar->waktu_keluar)->diffInDays(Carbon::parse($masuk->waktu_masuk)) + 1;
                } else {
                    // Jika tidak ada data tidak ada pasien keluar
                    $tanggal_masuk_obj = Carbon::parse($masuk->waktu_masuk);
                    $tanggal_akhir_obj = Carbon::parse(end($jumlah_hari_per_periode)['akhir']);
                    
                    // Untuk log, ambil format Y-m-d
                    $tanggal_masuk = $tanggal_masuk_obj->format('Y-m-d');
                    $tanggal_akhir = $tanggal_akhir_obj->format('Y-m-d');
                    
                    // Hitung selisih hari + 1 agar inklusif
                    $hari_pasien += $tanggal_masuk_obj->diffInDays($tanggal_akhir_obj) + 1;                    
                }

                // Tambahkan hari pindah, jika ada yang cocok (asal atau tujuan bangsal)
                $pindah = $pindahCollection->first(function ($item) use ($masuk) {
                    return $item->fk_id_pasien_masuk == $masuk->id_pasien_masuk;
                });

                if ($pindah) {
                    $hari_pasien += Carbon::parse($pindah->waktu_pindah)->diffInDays(Carbon::parse($masuk->waktu_masuk));
                }
    
                // Total hari per pasien di bangsal ini
                $jumlah_hari += $hari_pasien;
            }
    
            // Total hari perawatan di bangsal
            $jumlah_hari_perawatan[$kdBangsal] = $jumlah_hari;
            Log::info('
                ==============================================
                Jumlah Hari Perawatan di Bangsal ' . $kdBangsal . ': ' . $jumlah_hari . '
                ==============================================
            ');
        }
    
        return $jumlah_hari_perawatan;
    }
}
