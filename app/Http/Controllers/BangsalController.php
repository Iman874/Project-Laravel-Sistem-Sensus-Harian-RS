<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bangsal;
use App\Models\KelasBangsal;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BangsalController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;
        $gelar = $user->gelar ?? null;
        $penempatan = $user->penempatan ?? null; // hanya untuk perawat
        $bangsal = Bangsal::all();
        $kelas_bangsal = KelasBangsal::all();

        return view('page.home', compact(
            'role', 
            'nama', 
            'gelar', 
            'penempatan',
            'bangsal',
            'kelas_bangsal',
        ));
    }

    // create/store
    public function store(Request $request)
    { 
        // Validasi input
        $validatedData = $request->validate([
            'nama_bangsal' => 'required|string|max:255',
            'total_tempat_tidur',
        ]);
    
        // Debug data yang diterima di console log Laravel
        Log::debug('Data yang diterima untuk disimpan:', $validatedData);
    
        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method store dari model Bangsal
            Bangsal::create($validatedData);

            // log debug
            Log::info('Data Bangsal berhasil disimpan', $validatedData);
            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menyimpan data Bangsal', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // ambil data untuk diubah/edit
    public function edit($id)
    {
        $bangsal = Bangsal::findOrFail($id);
        return response()->json($bangsal);
    }

    // edit/update
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_bangsal' => 'required|string|max:255',
            'total_tempat_tidur' => 'required|integer|min:0',
        ]);
    
        // Debug data yang diterima di console log Laravel
        Log::debug('Data Bangsal yang diterima untuk disimpan (edit):', $validatedData);
    
        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method update dari model Bangsal
            Bangsal::find($id)->update($validatedData);

            // buat log untuk debug
            Log::info('Data Bangsal berhasil diubah', $validatedData);
            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menyimpan data Bangsal', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // delete
    public function destroy($id)
    {
        // Metode
        try {
            // Panggil method delete dari model Bangsal
            Bangsal::find($id)->delete();
            // Redirect kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menghapus data Bangsal', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }


    // get Chart Data
    public function getChartData(Request $request)
    {
        $bangsal = Bangsal::all();
        $kelas_bangsal = KelasBangsal::all();

        $filter = $request->query('filter', 'all'); // "terpakai", "tersedia", atau "all"
        $perPage = $request->query('per_page', 5);
        $page = $request->query('page', 1);

        // Ambil pasien masuk yang belum keluar/pindah
        $pasien_masuk = PasienMasuk::doesntHave('pasien_keluar')
            ->doesntHave('pasien_pindahs')
            ->with('kelas_bangsal')
            ->get();

        // Ambil pasien yang pindah (hanya yang terbaru)
        $pasien_pindah_all = PasienPindah::doesntHave('pasien_keluar')
            ->with('kelas_bangsal_tujuan')
            ->get();
        $pasien_pindah = $pasien_pindah_all->groupBy('fk_id_pasien_masuk')->map(function ($group) {
            return $group->sortByDesc('waktu_pindah')->first();
        });

        $data = [];

        foreach ($bangsal as $item) {
            $jenis_kelas_terpakai = [];
            $jenis_kelas_tersedia = [];

            // Ambil jenis kelas unik dari bangsal ini
            $jenis_kelas_dalam_bangsal = $kelas_bangsal
                ->where('fk_kd_bangsal', $item->kd_bangsal)
                ->pluck('jenis_kelas')
                ->unique();

            // Inisialisasi tempat tidur untuk tiap jenis kelas
            foreach ($jenis_kelas_dalam_bangsal as $jenis_kelas) {
                $jumlah_tempat_tidur = $kelas_bangsal
                    ->where('fk_kd_bangsal', $item->kd_bangsal)
                    ->where('jenis_kelas', $jenis_kelas)
                    ->sum('jumlah_tempat_tidur');

                $jenis_kelas_terpakai[$jenis_kelas] = 0;
                $jenis_kelas_tersedia[$jenis_kelas] = $jumlah_tempat_tidur;
            }

            // Hitung pasien masuk berdasarkan jenis kelas
            foreach ($pasien_masuk as $pasien) {
                if ($item->kd_bangsal == $pasien->fk_kd_bangsal && $pasien->kelas_bangsal) {
                    $jenis_kelas = $pasien->kelas_bangsal->jenis_kelas;
                    if (isset($jenis_kelas_terpakai[$jenis_kelas])) {
                        $jenis_kelas_terpakai[$jenis_kelas]++;
                        $jenis_kelas_tersedia[$jenis_kelas] = max(0, $jenis_kelas_tersedia[$jenis_kelas] - 1);
                    }
                }
            }

            // Hitung pasien pindah berdasarkan jenis kelas
            foreach ($pasien_pindah as $pasien) {
                if ($item->kd_bangsal == $pasien->fk_tujuan_bangsal && $pasien->kelas_bangsal_tujuan) {
                    $jenis_kelas = $pasien->kelas_bangsal_tujuan->jenis_kelas;
                    if (isset($jenis_kelas_terpakai[$jenis_kelas])) {
                        $jenis_kelas_terpakai[$jenis_kelas]++;
                        $jenis_kelas_tersedia[$jenis_kelas] = max(0, $jenis_kelas_tersedia[$jenis_kelas] - 1);
                    }
                }
            }

            // **Terapkan filter**
            $kelas_data = [];

            if ($filter === 'terpakai') {
                foreach ($jenis_kelas_terpakai as $jenis => $jumlah) {
                    if ($jumlah > 0) { // Hanya ambil jika ada data
                        $kelas_data[] = [
                            'jenis_kelas' => $jenis,
                            'terpakai' => $jumlah,
                            'tersedia' => 0 // Supaya tidak menyebabkan error di frontend
                        ];
                    }
                }
            } elseif ($filter === 'tersedia') {
                foreach ($jenis_kelas_tersedia as $jenis => $jumlah) {
                    if ($jumlah > 0) { // Hanya ambil jika ada data
                        $kelas_data[] = [
                            'jenis_kelas' => $jenis,
                            'terpakai' => 0, // Supaya tidak menyebabkan error di frontend
                            'tersedia' => $jumlah
                        ];
                    }
                }
            } else { // Default "all"
                // Gabungkan semua jenis kelas yang ada dalam terpakai dan tersedia
                $semua_jenis_kelas = array_unique(array_merge(array_keys($jenis_kelas_terpakai), array_keys($jenis_kelas_tersedia)));

                foreach ($semua_jenis_kelas as $jenis) {
                    $kelas_data[] = [
                        'jenis_kelas' => $jenis,
                        'terpakai' => $jenis_kelas_terpakai[$jenis] ?? 0,
                        'tersedia' => $jenis_kelas_tersedia[$jenis] ?? 0
                    ];
                }
            }

            // Tambahkan ke hasil akhir
            $data[] = [
                'bangsal' => $item->nama_bangsal,
                'kelas' => $kelas_data, // Menyimpan data dalam bentuk array agar mudah diproses di frontend
            ];
        }

        // Pagination manual
        $total = count($data);
        $paginatedData = array_slice($data, ($page - 1) * $perPage, $perPage);

        return response()->json([
            'data' => $paginatedData,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
        ]);
    }

}
