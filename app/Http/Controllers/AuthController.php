<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    // Index
    public function index()
    {
        return view('page.login');
    }

    // Dashboard
    public function dashboard()
    {
        // Pastikan user sudah login
        if (!Auth::guard(session('guard'))->check()) {
            return redirect()->route('login-page')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;
        $gelar = $user->gelar ?? null;
        $penempatan = $user->penempatan ?? null; // Pastikan kolom ini ada dalam database

        return view('page.home', compact('role', 'nama', 'gelar', 'penempatan'));
    }

    // Login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Hapus sesi login sebelumnya
        session()->flush();

        // Cek login di setiap guard sesuai role, dan logout jika ada
        $guards = ['petugas_indikator', 'perawat', 'kepala'];
        foreach ($guards as $guard) {
            Auth::guard($guard)->logout();
        }

        // Data login
        $credentials = $request->only('username', 'password');

        // Cek apakah username ada di salah satu guard
        $userFound = false;
        foreach ($guards as $guard) {
            $user = Auth::guard($guard)->getProvider()->retrieveByCredentials(['username' => $credentials['username']]);
            if ($user) {
                $userFound = true;
                break;
            }
        }

        // Cek login di setiap guard sesuai role, dan login jika ada
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                // Ambil user
                $user = Auth::guard($guard)->user();

                // Pastikan user memiliki role
                if (!$user->role) {
                    Auth::guard($guard)->logout();
                    return response()->json(['message' => 'User role is not defined'], 403);
                }

                // Simpan sesi
                session([
                    'user_id' => $user->id_petugas ?? $user->id_perawat ?? $user->id_kepala_instalasi,
                    'role' => $user->role,
                    'guard' => $guard,
                ]);

                // Redirect ke dashboard
                $roleRoute = match ($user->role) {
                    'petugas_indikator' => 'petugas_indikator.dashboard',
                    'perawat' => 'perawat.dashboard',
                    'kepala_instalasi' => 'kepala_instalasi.dashboard',
                };

                return redirect()->route($roleRoute);
            }
        }

        // Pesan error yang lebih spesifik
        if (!$userFound) {
            return redirect()->back()->with('login_error', Crypt::encryptString('Username tidak ditemukan.'));
        }

        return redirect()->back()->with('login_error', Crypt::encryptString('Password salah.'));
    }


    // Logout
    public function logout()
    {
        // Logout dari guard yang sedang aktif
        Auth::guard(session('guard'))->logout();
        // Hapus sesi
        session()->flush();

        // Redirect ke halaman login
        return redirect()->route('login-page');
    }
}
