<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\KelasBangsal;
use Illuminate\Support\Facades\Crypt;

class KelasBangsalController extends Controller
{
    // create/store
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jenis_kelas' => 'required|string|max:255',
            'jumlah_tempat_tidur' => 'required|integer|min:0',
            'fk_kd_bangsal' => 'required|exists:bangsal,kd_bangsal',
        ]);
    
        // Debug data yang diterima di console log Laravel
        Log::debug('Data yang diterima untuk disimpan:', $validatedData);
    
        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method store dari model KelasBangsal
            KelasBangsal::create($validatedData);
            
            // log info
            Log::info('Data berhasil disimpan ke database', $validatedData);
            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            // log error
            Log::error('Gagal menyimpan data ke database', $e);

            // Redirect kembali ke halaman sebelumnya dengan pesan error
            // return redirect()->back()->with('error', 'Gagal menyimpan data ke database');
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // edit/update
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jenis_kelas' => 'required|string|max:255',
            'jumlah_tempat_tidur' => 'required|integer|min:0',
            'fk_kd_bangsal' => 'required|exists:bangsal,kd_bangsal',
        ]);
    
        // Debug data yang diterima di console log Laravel
        Log::debug('Data yang diterima untuk disimpan:', $validatedData);
    
        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method update dari model KelasBangsal
            $kelasBangsal = KelasBangsal::findOrFail($id);
            $kelasBangsal->fill($validatedData);
            $kelasBangsal->save(); // Ini akan memicu event `updated total tempat tidur` di model kelas bangsal

            // log info
            Log::info('Data berhasil diubah', $validatedData);
            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            // log error untuk debug
            Log::error('Terjadi error saat menyimpan data Kelas Bangsal', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Redirect kembali ke halaman sebelumnya dengan pesan error
            // return redirect()->back()->with('error', 'Gagal menyimpan data ke database');
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // ambil data untuk diubah/edit
    public function edit($id)
    {
        $kelasBangsal = KelasBangsal::findOrFail($id);
        return response()->json($kelasBangsal);
    }

    // delete
    public function destroy($id)
    {
        // Metode
        try {
            // Panggil method delete dari model KelasBangsal
            KelasBangsal::find($id)->delete();
            // Redirect kembali ke halaman sebelumnya dengan pesan sukses
            // return redirect()->back()->with('success', 'Data berhasil dihapus');
            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menyimpan data Bangsal', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            // return redirect()->back()->with('error', 'Terjadi error saat menghapus data');
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }
}
