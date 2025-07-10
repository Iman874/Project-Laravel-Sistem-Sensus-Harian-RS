@extends('layout.auth')

@section('title', 'No Access')

@section('field')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="display-3 text-danger">403</h1>
        <h2 class="mb-3">Akses Ditolak</h2>
        <p class="text-muted">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        @php
            // Mendapatkan role dari user yang sedang login
            $role = Auth::guard(session('guard'))->user()->role;
        @endphp

        <!-- Jika User belum login, maka akan diarahkan ke halaman login -->
        @if (Auth::guard(session('guard'))->user()->check)
            <a href="{{ route('login-page') }}" class="btn btn-primary">Kembali ke Halaman Login</a>

        <!-- Jika User sudah login, maka akan diarahkan ke halaman dashboard -->
        @else
            <a href="{{ route($role . '.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
        
        @endif
    </div>
</div>
@endsection
