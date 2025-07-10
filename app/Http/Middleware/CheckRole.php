<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Ambil guard dari session, gunakan 'web' jika tidak ada
        $guard = session('guard', 'web');

        // Jika user belum login, redirect ke halaman login
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login-page')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pengguna yang sedang login
        $user = Auth::guard($guard)->user();

        // Jika role tidak sesuai, tampilkan halaman no-access
        if ($user->role !== $role) {
            return response()->view('page.no-access', [], 403);
        }

        // Lanjut ke request berikutnya (tidak memaksa redirect)
        return $next($request);
    }
}