<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KelasBangsal;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;

class JumlahTempatTidur extends Model
{
    public $bangsalId;
    public $kelasId;
    public $tempatTidurTersedia;
    public $tempatTidurTerpakai;

    public function __construct($bangsalId, $kelasId)
    {
        $this->bangsalId = $bangsalId;
        $this->kelasId = $kelasId;
        $this->hitungTempatTidur();
    }

    private function hitungTempatTidur()
    {
        // Ambil total tempat tidur dari model KelasBangsal
        $kelasBangsal = KelasBangsal::where('id_kelas', $this->kelasId)
            ->where('fk_kd_bangsal', $this->bangsalId)
            ->first();

        // Ambil jumlah pasien yang sedang menempati bangsal tersebut
        $pasienMasuk = PasienMasuk::doesntHave('pasien_keluar')
            ->doesntHave('pasien_pindahs')
            ->where('fk_kd_bangsal', $this->bangsalId)
            ->where('fk_id_kelas', $this->kelasId)
            ->count();

        // Seleksi id pasien pindah, ambil data waktu pindah terbaru
        $pasien_pindah_all = PasienPindah::withAllRelations()->get();
        $pasien_pindahTerbaru = $pasien_pindah_all->groupBy('fk_id_pasien_masuk')->map(function ($group) {
            return $group->sortByDesc('waktu_pindah')->first();
        });

        // Ambil jumlah pasien pindah yang belum keluar
        $pasien_pindahTerbaru = $pasien_pindahTerbaru->where('fk_tujuan_bangsal', $this->bangsalId)
            ->where('fk_id_kelas_tujuan', $this->kelasId)
            ->count();

        // Hitung jumlah pasien yang menempati tempat tidur
        $pasienTerpakai = $pasienMasuk + $pasien_pindahTerbaru;

        // Simpan hasilnya
        $this->tempatTidurTersedia = $kelasBangsal->jumlah_tempat_tidur - $pasienTerpakai;
        $this->tempatTidurTerpakai = $pasienTerpakai;
        $this->namaBangsal = $kelasBangsal->bangsal->nama_bangsal;
        $this->namaKelas = $kelasBangsal->nama_kelas;
    }
}
