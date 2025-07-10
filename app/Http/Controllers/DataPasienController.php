<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use App\Models\PasienKeluar;
use App\Models\Bangsal;
use App\Models\KelasBangsal;

class DataPasienController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;

        // Data pasien (pasien_masuk, pasien_pindah, pasien_keluar)
        $pasien_masuk = PasienMasuk::withAllRelations()->get(); // ambil semua data pasien masuk dan relasi nya
        $pasien_pindah = PasienPindah::withAllRelations()->get(); // ambil semua data pasien pindah dan relasi nya
        $pasien_keluar = PasienKeluar::withAllRelations()->get(); // ambil semua data pasien keluar dan relasi nya

        // Ambil data pasien masuk, pasien_pindah, pasien_keluar hari ini
        /*
        $data_pasien_masuk_hari_ini = PasienMasuk::whereDate('waktu_masuk', now()->toDateString())->get();
        $data_pasien_pindah_hari_ini = PasienPindah::whereDate('waktu_pindah', now()->toDateString())->get();
        $data_pasien_keluar_hari_ini = PasienKeluar::whereDate('waktu_keluar', now()->toDateString())->get();
        */
        $data_pasien_masuk_hari_ini = PasienMasuk::whereDate('waktu_masuk', '2025-03-20')->get();
        $data_pasien_pindah_hari_ini = PasienPindah::whereDate('waktu_pindah', '2025-03-20')->get();
        $data_pasien_keluar_hari_ini = PasienKeluar::whereDate('waktu_keluar', '2025-03-20')->get();

        // Ambil data bangsal
        $bangsal = Bangsal::with('kelas_bangsals')->get();
        $kelas_bangsal = KelasBangsal::withAllRelations()->get();

        //dd($pasien_keluar);
    
        // Ambil data total data pasien masuk, keluar
        $pasien_masuk_hari_ini = PasienMasuk::whereDate('waktu_masuk', date('Y-m-d'))->count();
        $pasien_keluar_hari_ini = PasienKeluar::whereDate('waktu_keluar', date('Y-m-d'))->count();

        return view('page.home', compact(
            'role',
            'nama',
            'pasien_masuk',
            'pasien_pindah',
            'pasien_keluar',
            'pasien_masuk_hari_ini',
            'pasien_keluar_hari_ini',
            'bangsal',
            'kelas_bangsal',
            'data_pasien_masuk_hari_ini',
            'data_pasien_pindah_hari_ini',
            'data_pasien_keluar_hari_ini'
        ));
    }
}
