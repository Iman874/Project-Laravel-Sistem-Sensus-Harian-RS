<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JumlahTempatTidur;
use App\Models\Bangsal;
use App\Models\KelasBangsal;

class testing extends Controller
{
    public function cekTempatTidur()
    {
        // Ambil semua bangsal dan kelas bangsal
        $bangsals = Bangsal::all();
        $kelasList = KelasBangsal::all();
    
        // Array untuk menyimpan hasil
        $hasil = [];

        // Index untuk mengecek tempat tidur tersedia dan terpakai
        $index = 0;
    
        foreach ($bangsals as $bangsal) {
            foreach ($kelasList as $kelas) {
                // Pastikan hanya mengambil data yang sesuai
                if ($kelas->fk_kd_bangsal == $bangsal->kd_bangsal) {
                    $tempatTidur = new JumlahTempatTidur($bangsal->kd_bangsal, $kelas->id_kelas);
    
                    // Simpan data ke array hasil
                    $hasil[] = [
                        'nama_bangsal' => $bangsal->nama_bangsal,
                        'nama_kelas' => $kelas->nama_kelas,
                        'tempat_tidur_tersedia' => $tempatTidur->tempatTidurTersedia,
                        'tempat_tidur_terpakai' => $tempatTidur->tempatTidurTerpakai
                    ];

                    // Jika di temukan tempat tidur tersedia bernilai -1 atau lebih kecil
                    if ($tempatTidur->tempatTidurTersedia < 0 || $tempatTidur->tempatTidurTerpakai < 0) {
                        $index++;
                        // Ambil id bangsal dan kelas bangsal
                        $kd_bangsal = $bangsal->kd_bangsal;
                        $id_kelas = $kelas->id_kelas;
                    }
                }
            }
        }

        // Jika index bernilai lebih dari 0, maka ada tempat tidur yang tidak valid
        if ($index > 0) {
            return response()->json([
                'message' => 'Ada tempat tidur yang tidak valid',
                'status' => 'error',
                'data tidak valid' => [
                    'kd_bangsal' => $kd_bangsal,
                    'id_kelas' => $id_kelas
                ],
                'data valid' => $hasil
            ], 400, [], JSON_PRETTY_PRINT);
        }
    
        return response()->json([
            'message' => 'Berhasil menghitung tempat tidur',
            'status' => 'success',
            'data valid' => $hasil
        ], 200, [], JSON_PRETTY_PRINT);
    }
    
}
