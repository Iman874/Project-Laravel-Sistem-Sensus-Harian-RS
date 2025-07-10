<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil guard dari session, gunakan 'web' jika tidak ada
        $guard = session('guard', 'web');

        // Jika user belum login, redirect ke halaman login
        if (!Auth::guard($guard)->check()) {
             return redirect()->route('login-page')->with('error', 'Silakan login terlebih dahulu.');
        }
 
        // Lanjut ke request berikutnya (tidak memaksa redirect)
        return $next($request);
    }
}
