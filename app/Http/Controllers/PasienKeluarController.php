<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogsTabelPasien;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
use App\Models\PasienPindah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PasienKeluarController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        $role = $user->role ?? null;
        $nama = $user->nama ?? null;
        $penempatan = $user->penempatan ?? null;

        // Ambil data pasien keluar yang pernah dipindahkan
        $DataPasienKeluar_pindah = PasienKeluar::WithBangsalTujuan()
        ->hasPindah()
        ->get();

        // Filter pasien yang bangsal_tujuannya sesuai dengan `$penempatan`
        $DataPasienKeluar_pindah = $DataPasienKeluar_pindah->filter(function ($pasien) use ($penempatan) {
            return optional(optional($pasien->pasien_masuk)->pasien_pindahs->sortByDesc('waktu_pindah')->first())->bangsal_tujuan->nama_bangsal === $penempatan;
        })->values(); // Reset index        

        // Ambil data pasien keluar yang tidak pernah dipindahkan
        $DataPasienKeluar = PasienKeluar::WithAllRelations()->notPindah()->get();

        // Filter pasien yang bangsalnya sesuai dengan `$penempatan`
        $DataPasienKeluar = $DataPasienKeluar->filter(function ($pasien) use ($penempatan) {
            return optional(optional($pasien->pasien_masuk)->bangsal)->nama_bangsal === $penempatan;
        })->values(); // Reset index
        
        $pasien_masukKeluar = PasienMasuk::with(['bangsal', 'pasien_pindahs.bangsal_asal', 'pasien_pindahs.bangsal_tujuan'])
        ->whereDoesntHave('pasien_keluar')->whereDoesntHave('pasien_pindahs')  // Ambil yang tidak ada di pasien_keluar
        ->whereHas('bangsal', function ($query) use ($penempatan) { // Ambil yang ada di bangsal yang sesuai dengan penempatan
            $query->where('nama_bangsal', $penempatan);
        })
        ->get();

        $pasien_pindahKeluar = PasienMasuk::with([
            'bangsal', 
            'pasien_pindahs', 
            'pasien_pindahs.bangsal_asal', 
            'pasien_pindahs.bangsal_tujuan'
        ])
        ->whereDoesntHave('pasien_keluar')
        ->whereHas('pasien_pindahs')->get();

        // Ambil pasien pindah terbaru berdasarkan `waktu_pindah`
        $pasien_pindahKeluar = $pasien_pindahKeluar->map(function ($pasien) {
            $pasien->pasien_pindahs = $pasien->pasien_pindahs->sortByDesc('waktu_pindah')->first();
            return $pasien;
        })->filter(function ($pasien) use ($penempatan) {
            // Pastikan pasien punya data pindah terbaru dan bangsal_tujuannya sesuai
            return $pasien->pasien_pindahs !== null 
                && $pasien->pasien_pindahs->bangsal_tujuan !== null
                && $pasien->pasien_pindahs->bangsal_tujuan->nama_bangsal === $penempatan;
        });

        // Ambil pasien pindah terbaru berdasarkan fk_id_pasien_masuk
        $pasien_pindahTerbaru = PasienPindah::whereIn('fk_id_pasien_masuk', $pasien_masukKeluar->pluck('id_pasien_masuk'))
        ->orderBy('waktu_pindah', 'desc')
        ->get();
    
        $pasien_notPindahKeluar = PasienMasuk::with(['pasien_keluar', 'bangsal'])
        ->whereDoesntHave('pasien_pindahs') // Pastikan pasien belum pernah pindah
        ->whereHas('pasien_keluar') // Pastikan pasien sudah keluar
        ->whereHas('bangsal', function ($query) use ($penempatan) {
            $query->where('nama_bangsal', $penempatan);
        })
        ->get();
    
        // Encrypt seluruh data
        $data = Crypt::encrypt([
            'DataPasienKeluar' => $DataPasienKeluar,
            'DataPasienKeluar_pindah' => $DataPasienKeluar_pindah,
            'pasien_masukKeluar' => $pasien_masukKeluar,
            'pasien_pindahKeluar' => $pasien_pindahKeluar,
            'pasien_notPindahKeluar' => $pasien_notPindahKeluar
        ]);


        return view('page.home', compact(
            'data',
            'role',
            'nama'
        ));
    }
    
    // create log
    private function createLog($action, $role, $id_role)
    {
        return LogsTabelPasien::create([
            'action' => $action,
            'role' => $role,
            'id_role' => $id_role
        ]);
    }

    // create/store pasien keluar
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'fk_id_pasien_masuk' => 'required|integer|exists:pasien_masuk,id_pasien_masuk',
            'waktu_keluar' => 'required|date',
            'cara_keluar' => 'required|string|max:255'
        ]);

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('create', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien keluar', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;
        
        // Simpan data ke database
        try {
            PasienKeluar::create($validatedData);
            Log::info('Data Pasien Keluar berhasil disimpan', ['data' => $validatedData]);
            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat menyimpan data Pasien Keluar', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // update
    public function update(Request $request, $id)
    {        
        // Validasi input dari form
        $validatedData = $request->validate([
            'fk_id_pasien_masuk' => 'required|integer|exists:pasien_masuk,id_pasien_masuk',
            'waktu_keluar' => 'required|date',
            'cara_keluar' => 'required|string|max:255'
        ]);

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('update', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien keluar', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;

        // Simpan data ke database
        try {
            PasienKeluar::where('fk_id_pasien_masuk', $id)->update($validatedData);
            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat mengubah data Pasien Keluar', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // edit, fungsi get data untuk diubah
    public function edit($id)
    {
        $pasienKeluar = PasienKeluar::with('pasien_masuk')->find($id);

        if (!$pasienKeluar) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    
        return response()->json($pasienKeluar);        
    }

    // delete
    public function destroy($id)
    {
        $pasien_keluar = PasienKeluar::find($id);

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('delete', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien keluar', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $pasien_keluar->fk_id_logs = $log->id_logs;

        // Simpan data ke database
        try {
            $pasien_keluar->delete();
            Log::info('Data Pasien Keluar berhasil dihapus', ['data' => $pasien_keluar]);
            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat menghapus data Pasien Keluar', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }

        return redirect()->back();
    }

    // get role id name
    private function getRoleIdName($role)
    {
        if ($role === 'petugas_indikator') {
            return 'id_petugas';
        } elseif ($role === 'perawat') {
            return 'id_perawat';
        } elseif ($role === 'kepala_instalasi') {
            return 'id_kepala_instalasi';
        } else {
            return null;
        }
    }
}
