<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use App\Models\PasienKeluar;
use App\Models\Bangsal;
use App\Models\KelasBangsal;
use App\Models\JumlahTempatTidur;
use Illuminate\Support\Facades\Auth;
use App\Models\LogsTabelPasien;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PasienPindahController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        $role = $user->role ?? null; // Ambil role pengguna
        $nama = $user->nama ?? null; // Ambil nama pengguna

        // ambil data penempatan jika dia adalah perawat, jika tidak, isi dengan null
        $penempatan = $user->penempatan ?? null;

        // Ambil data bangsal dan relasi kelas bangsal
        $bangsal = Bangsal::with('kelas_bangsals')->get();

        // Ambil semua data pasien keluar
        $DataPasienKeluar = PasienKeluar::all();

        // Ambil data pasien masuk yang belum pernah pindah
        $pasien_masukPindah = PasienMasuk::withAllRelations()
        ->whereDoesntHave('pasien_pindahs')
        ->whereHas('bangsal', function ($query) use ($penempatan) {
            $query->where('nama_bangsal', $penempatan);
        })
        ->get();

        // Seleksi pasien masuk, jika sudah pernah keluar, hapus dari daftar
        $pasien_masukPindah = $pasien_masukPindah->reject(function ($pasien) use ($DataPasienKeluar) {
        return $DataPasienKeluar->contains('fk_id_pasien_masuk', $pasien->id_pasien_masuk);
        });

        // Ambil data pasien yang pernah pindah tetapi belum keluar
        $pasien_pindah = PasienPindah::withAllRelations()->withBangsalAsal()->withBangsalTujuan()
        ->whereDoesntHave('pasien_keluar')
        ->where(function ($query) use ($penempatan) {
            $query->whereHas('bangsal_tujuan', function ($q) use ($penempatan) {
                $q->where('nama_bangsal', $penempatan);
            })->orWhereHas('bangsal_asal', function ($q) use ($penempatan) {
                $q->where('nama_bangsal', $penempatan);
            });
        })
        ->get();

        // Seleksi id pasien pindah, ambil data waktu pindah terbaru
        $pasien_pindah_all = PasienPindah::all();
        $pasien_pindahTerbaru = $pasien_pindah_all->groupBy('fk_id_pasien_masuk')->map(function ($group) {
            return $group->sortByDesc('waktu_pindah')->first();
        });
            
        // $pasien_masukPindah = semua data pasien masuk (yang belum pernah pindah)
        // $pasien_pindah = semua data pasien pindah (yang belum pernah keluar)
        // $pasien_pindahTerbaru = data pasien yang paling baru (waktu pindah) untuk setiap pasien masuk

        // Encrypt seluruh data
        $data = Crypt::encrypt([
            'pasien_masukPindah' => $pasien_masukPindah,
            'pasien_pindah' => $pasien_pindah,
            'pasien_pindahTerbaru' => $pasien_pindahTerbaru,
            'bangsal' => $bangsal
        ]);

        return view('page.home', compact(
            'data',
            'role',
            'nama',
            'penempatan'
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

    // create/store pasien pindah
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input dari form
        $validatedData = $request->validate([
            'fk_id_pasien_masuk' => 'required|integer|exists:pasien_masuk,id_pasien_masuk',
            'fk_asal_bangsal' => 'required|integer|exists:bangsal,kd_bangsal',
            'fk_tujuan_bangsal' => 'required|integer|exists:bangsal,kd_bangsal',
            'fk_id_kelas_asal' => 'required|integer|exists:kelas_bangsal,id_kelas',
            'fk_id_kelas_tujuan' => 'required|integer|exists:kelas_bangsal,id_kelas',
            'waktu_pindah' => 'required|date'
        ]);

        // Cek apakah tempat tidur di bangsal baru tersedia
        $tempatTidurBaru = new JumlahTempatTidur($validatedData['fk_tujuan_bangsal'], $validatedData['fk_id_kelas_tujuan']);

        if ($tempatTidurBaru->tempatTidurTersedia <= 0) {
            return redirect()->back()->with('status', Crypt::encryptString('Tempat Tidur Tidak Tersedia!'));
        }

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('create', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien pindah', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;

        // Simpan data ke database
        try {
            PasienPindah::create($validatedData);
            Log::info('Data Pasien Pindah berhasil disimpan', ['data' => $validatedData]);
            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat menyimpan data Pasien Pindah', [
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
        //dd($request->all());
        // Validasi input dari form
        $validatedData = $request->validate([
            'fk_id_pasien_masuk' => 'required|integer|exists:pasien_masuk,id_pasien_masuk',
            'fk_tujuan_bangsal' => 'required|integer|exists:bangsal,kd_bangsal',
            'fk_id_kelas_tujuan' => 'required|integer|exists:kelas_bangsal,id_kelas',
            'waktu_pindah' => 'required|date'
        ]);

        // Cek apakah tempat tidur di bangsal baru tersedia
        $tempatTidurBaru = new JumlahTempatTidur($validatedData['fk_tujuan_bangsal'], $validatedData['fk_id_kelas_tujuan']);

        if ($tempatTidurBaru->tempatTidurTersedia <= 0) {
            return redirect()->back()->with('status', Crypt::encryptString('Tempat Tidur Tidak Tersedia!'));
        }

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('update', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien pindah', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;

        // Simpan data ke database
        try {
            PasienPindah::where('id_pindah', $id)->update($validatedData);
            Log::info('Data Pasien Pindah berhasil diubah', ['data' => $validatedData]);
            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat mengubah data Pasien Pindah', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }

        return redirect()->back();
    }

    // edit, fungsi get data untuk diubah
    public function edit($id)
    {
        $pasienPindah = PasienPindah::with('pasien_masuk', 'bangsal_asal', 'bangsal_tujuan', 'kelas_bangsal_asal', 'kelas_bangsal_tujuan')->find($id);

        if (!$pasienPindah) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($pasienPindah);
    }

    // delete
    public function destroy($id)
    {
        $pasien_pindah = PasienPindah::find($id);

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('delete', $role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            Log::error('Gagal membuat log pasien pindah', ['role' => $role, 'id_role' => $id_role]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $pasien_pindah->fk_id_logs = $log->id_logs;

        // Simpan data ke database
        try {
            $pasien_pindah->delete();
            Log::info('Data Pasien Pindah berhasil dihapus', ['data' => $pasien_pindah]);
            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            Log::error('Terjadi error saat menghapus data Pasien Pindah', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
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

    // Fungsi khusus untuk data pasien pindah
    public function getPasienPindahSebelumnya($id){
        $pasien_pindah = PasienPindah::with('pasien_masuk')
        ->where('id_pindah', $id)->get();

        if ($pasien_pindah->isEmpty()) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Cek apakah pasien pindah memiliki data pasien pindah sebelumnya
        $pasien_pindah_sebelumnya = PasienPindah::where('fk_id_pasien_masuk', $pasien_pindah[0]->fk_id_pasien_masuk)
            ->where('waktu_pindah', '<', $pasien_pindah[0]->waktu_pindah)
            ->orderBy('waktu_pindah', 'desc')
            ->first();

        if ($pasien_pindah_sebelumnya) {
            return response()->json($pasien_pindah_sebelumnya);
        } else {
            // Jika tidak di temukan maka kembalikan data pasien masuk yang berelasi dengan pasien pindah terkait
            $pasien_masuk = PasienMasuk::with('pasien_pindahs')
                ->where('id_pasien_masuk', $pasien_pindah[0]->fk_id_pasien_masuk)
                ->first();
            return response()->json($pasien_masuk);
        }
    }
}
