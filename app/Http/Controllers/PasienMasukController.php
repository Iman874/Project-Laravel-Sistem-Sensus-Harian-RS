<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Bangsal;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use App\Models\PasienKeluar;
use App\Models\LogsTabelPasien;
use App\Models\KelasBangsal;
use App\Models\JumlahTempatTidur;
use Illuminate\Support\Facades\Crypt;

class PasienMasukController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;
        $penempatan = $user->penempatan ?? null; // hanya untuk perawat

        // Seleksi data sesuai penempatan, jika penempatan tidak kosong
        if ($penempatan) {
            // Satu akun perawat hanya boleh memiliki satu penempatan
            // Ambil Bangsal yang sesuai dengan penempatan
            $bangsal = Bangsal::where('nama_bangsal', $penempatan)->get();
            
            // Ambil ID bangsal yang cocok
            $kd_bangsal_list = $bangsal->pluck('kd_bangsal');
        
            // Ambil kelas bangsal yang memiliki bangsal tersebut
            $kelas_bangsal = KelasBangsal::whereIn('fk_kd_bangsal', $kd_bangsal_list)
            ->with('bangsal') // Eager load relasi bangsal
            ->get();
        
            // Ambil pasien masuk yang berhubungan dengan bangsal tertentu
            $pasien_masuk = PasienMasuk::whereIn('fk_kd_bangsal', $kd_bangsal_list)
            ->doesntHave('pasien_keluar')
            ->get();
        }

        // Encrypt seluruh data
        $data = Crypt::encrypt([
            'pasien_masuk' => $pasien_masuk,
            'bangsal' => $bangsal,
            'kelas_bangsal' => $kelas_bangsal
        ]);
        
        // Tampilkan view dengan data yang sudah diambil
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

    // create/store pasien masuk
    public function store(Request $request)
    {
        // debug
        // dd($request->all());
        // Validasi input dari form
        $validatedData = $request->validate([
            'no_rm' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'waktu_masuk' => 'required|date',
            'fk_kd_bangsal' => 'required|integer|exists:bangsal,kd_bangsal',
            'fk_id_kelas' => 'required|integer|exists:kelas_bangsal,id_kelas'
        ]);

        // cek apakah no rm sudah ada di tabel pasien masuk
        if(PasienMasuk::where('no_rm', $validatedData['no_rm'])->first()) {
            return redirect()->back()->with('status', Crypt::encryptString('Eror No RM Sudah Ada'));
        }

        // Cek apakah tempat tidur di bangsal baru tersedia
        $tempatTidurBaru = new JumlahTempatTidur($validatedData['fk_kd_bangsal'], $validatedData['fk_id_kelas']);

        if ($tempatTidurBaru->tempatTidurTersedia <= 0) {
            return redirect()->back()->with('status', Crypt::encryptString('Tempat Tidur Tidak Tersedia!'));
        }

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Jika no_rm sudah ada di tabel pasien keluar, kembalikan ke halaman sebelumnya
        $pasien_keluar = PasienKeluar::with('pasien_masuk')
        ->whereHas('pasien_masuk', function ($query) use ($validatedData) {
            $query->where('no_rm', $validatedData['no_rm']);
        })
        ->first();
        if ($pasien_keluar) {
            return redirect()->back()->with('status', Crypt::encryptString('Eror No RM Sudah Ada pada Pasien Keluar'));
        }

        // Jika no_rm sudah ada di tabel pasien masuk, kembalikan ke halaman sebelumnya
        $pasien_masuk = PasienMasuk::where('no_rm', $validatedData['no_rm'])->first();
        if($pasien_masuk) {
            return redirect()->back()->with('status', Crypt::encryptString('Eror No RM Sudah Ada pada Pasien Masuk'));
        }

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('create', Auth::guard(session('guard'))->user()->role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            // Log error untuk debug
            Log::error('Gagal membuat log pasien masuk', [
                'role' => Auth::guard(session('guard'))->user()->role,
                'id_role' => $id_role
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;

        // log debug
        Log::info('Log pasien masuk berhasil dibuat', [
            'role' => Auth::guard(session('guard'))->user()->role,
            'id_role' => $id_role,
            'id_logs' => $log->id_logs
        ]);
        
        // log debug
        Log::info('Data Pasien Masuk yag akan dikirim',  ['data' => $validatedData]);

        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method create dari model PasienMasuk
            PasienMasuk::create($validatedData);

            // log debug
            Log::info('Data Pasien Masuk berhasil disimpan', ['data' => $validatedData]);
            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menyimpan data Pasien Masuk', [
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
        // debug
        //dd($request->all());
        // Validasi input dari form
        $validatedData = $request->validate([
            'no_rm' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'waktu_masuk' => 'required|date',
            'fk_kd_bangsal' => 'required|integer|exists:bangsal,kd_bangsal',
            'fk_id_kelas' => 'required|integer|exists:kelas_bangsal,id_kelas'
        ]);

        // Cek apakah tempat tidur di bangsal baru tersedia
        $tempatTidurBaru = new JumlahTempatTidur($validatedData['fk_kd_bangsal'], $validatedData['fk_id_kelas']);

        if ($tempatTidurBaru->tempatTidurTersedia <= 0) {
            return redirect()->back()->with('status', Crypt::encryptString('Tempat Tidur Tidak Tersedia!'));
        }

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('update', Auth::guard(session('guard'))->user()->role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            // Log error untuk debug
            Log::error('Gagal membuat log pasien masuk', [
                'role' => Auth::guard(session('guard'))->user()->role,
                'id_role' => $id_role
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $validatedData['fk_id_logs'] = $log->id_logs;

        // log debug
        Log::info('Log pasien masuk berhasil dibuat', [
            'role' => Auth::guard(session('guard'))->user()->role,
            'id_role' => $id_role,
            'id_logs' => $log->id_logs 
        ]);

        // log debug
        Log::info('Data Pasien Masuk yag akan dikirim',  ['data' => $validatedData]);

        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method update dari model PasienMasuk
            PasienMasuk::where('id_pasien_masuk', $id)->update($validatedData);

            // log debug
            Log::info('Data Pasien Masuk berhasil diubah', ['data' => $validatedData]);
            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat mengubah data Pasien Masuk', [
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
        // Ambil data pasien masuk berdasarkan id
        $pasien_masuk = PasienMasuk::find($id);
        return response()->json($pasien_masuk);
    }

    // delete
    public function destroy($id)
    {
        // Cari data pasien masuk berdasarkan id
        $pasien_masuk = PasienMasuk::find($id);

        // Cari id user berdasarkan user yang sedang login
        $role = Auth::guard(session('guard'))->user()->role;
        $roleIdName = $this->getRoleIdName($role);

        // Ambil id role dari user yang sedang login
        $id_role = Auth::guard(session('guard'))->user()->$roleIdName;

        // Sebelum menyimpan data pasien, buat log
        $log = $this->createLog('delete', Auth::guard(session('guard'))->user()->role, $id_role);

        // Jika gagal membuat log, kembalikan ke halaman sebelumnya
        if (!$log) {
            // Log error untuk debug
            Log::error('Gagal membuat log pasien masuk', [
                'role' => Auth::guard(session('guard'))->user()->role,
                'id_role' => $id_role
            ]);
            return redirect()->back()->with('status', Crypt::encryptString('eror_log'));
        }

        // Tambahkan id log ke data yang divalidasi
        $pasien_masuk->fk_id_logs = $log->id_logs;

        // log debug
        Log::info('Log pasien masuk berhasil dibuat', [
            'role' => Auth::guard(session('guard'))->user()->role,
            'id_role' => $id_role,
            'id_logs' => $log->id_logs
        ]);

        // log debug
        Log::info('Data Pasien Masuk yag akan dihapus',  ['data' => $pasien_masuk]);

        // Simpan data ke database
        // Metode Try-Catch untuk menangkap error
        try {
            // Panggil method delete dari model PasienMasuk
            $pasien_masuk->delete();

            // log debug
            Log::info('Data Pasien Masuk berhasil dihapus', ['data' => $pasien_masuk]);
            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Terjadi error saat menghapus data Pasien Masuk', [
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

    // get pasien masuk setelah
    public function getPasienMasukSetelah($id)
    {
        // Ambil data pasien masuk berdasarkan id
        $pasien_masuk = PasienMasuk::find($id);
        
        // Apakah data pasien masuk pernah pindah?
        $pasien_pindah = PasienPindah::where('fk_id_pasien_masuk', $id)->first();
        if ($pasien_pindah) {
            // Jika ada, ambil data pasien pindah
            $pasien_pindah = PasienPindah::where('fk_id_pasien_masuk', $id)->get();
        } else {
            // Jika tidak ada, kembalikan null
            $pasien_pindah = null;
        }

        // Apakah data pasien masuk pernah keluar?
        $pasien_keluar = PasienKeluar::where('fk_id_pasien_masuk', $id)->first();
        if ($pasien_keluar) {
            // Jika ada, ambil data pasien keluar
            $pasien_keluar = PasienKeluar::where('fk_id_pasien_masuk', $id)->get();
        } else {
            // Jika tidak ada, kembalikan null
            $pasien_keluar = null;
        }

        // Jika ada pasien pindah maka kirimkan data pasien pindah
        if ($pasien_pindah) {
            return response()->json([
                'waktu_terakhir' => $pasien_pindah->first()->waktu_pindah
            ]);
        } else if ($pasien_keluar) {
            // Jika tidak ada pasien pindah, kembalikan data pasien masuk dan pasien keluar
            return response()->json([
                'waktu_terakhir' => $pasien_keluar->first()->waktu_keluar
            ]);
        } else {
            // Jika tidak ada pasien pindah dan pasien keluar, kembalikan null
            return response()->json([
                'waktu_terakhir' => Null
            ]);
        }

    }
}
