<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BangsalController;
use App\Http\Controllers\KelasBangsalController;
use App\Http\Controllers\PasienMasukController;
use App\Http\Controllers\PasienPindahController;
use App\Http\Controllers\PasienKeluarController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\Testing;

// testing
use App\Http\Controllers\ModelRSController;

// Jika Belum login arahkan ke "/login"
Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard
    $role = Auth::guard(session('guard'))->user()->role;

    // Cek role pengguna
    if ($role === 'petugas_indikator') {
        return redirect('/petugas_indikator/dashboard');
    } elseif ($role === 'perawat') {
        return redirect('/perawat/dashboard');
    } elseif ($role === 'kepala_instalasi') {
        return redirect('/kepala_instalasi/dashboard');
    }
    // Jika belum login, arahkan ke halaman login
    return redirect ('/login');
})->middleware('auth.login'); // Middleware untuk mengecek apakah user sudah login

// Route untuk login
Route::get('/login', [AuthController::class, 'index'])->name('login-page');
Route::post('/login', [AuthController::class, 'login'])->name('route-login');

// Route untuk logout
Route::get('/logout', [AuthController::class, 'logout'])->name('route-logout');

// Route untuk dashboard
Route::middleware(['auth.login'])->group(function () {
    Route::get('/petugas_indikator/dashboard', [AuthController::class, 'dashboard'])
        ->middleware('role:petugas_indikator')
        ->name('petugas_indikator.dashboard');

    Route::get('/perawat/dashboard', [AuthController::class, 'dashboard'])
        ->middleware('role:perawat')
        ->name('perawat.dashboard');

    Route::get('/kepala_instalasi/dashboard', [AuthController::class, 'dashboard'])
        ->middleware('role:kepala_instalasi')
        ->name('kepala_instalasi.dashboard');
});

// Route untuk petugas indikator data pasien
Route::prefix('/petugas_indikator/data-pasien')->middleware(['auth.login', 'role:petugas_indikator'])->group(function () {
    Route::get('/', [DataPasienController::class, 'index'])->name('petugas_indikator.data-pasien.index');    
    // Route untuk pasien masuk
    Route::post('/', [PasienMasukController::class, 'store'])->name('store.petugas_indikator-pasienMasuk');
    Route::put('/{id}', [PasienMasukController::class, 'update'])->name('update.petugas_indikator-pasienMasuk');
    Route::get('/{id}/edit', [PasienMasukController::class, 'edit'])->name('edit.petugas_indikator-pasienMasuk');
    Route::delete('/{id}', [PasienMasukController::class, 'destroy'])->name('delete.petugas_indikator-pasienMasuk');
    Route::get('/{id}/setelah', [PasienMasukController::class, 'getPasienMasukSetelah'])->name('petugas_indikator-pasienMasuk.setelah');

    // Route untuk pasien pindah
    Route::post('/pindah', [PasienPindahController::class, 'store'])->name('store.petugas_indikator-pasienPindah');
    Route::put('/pindah/{id}', [PasienPindahController::class, 'update'])->name('update.petugas_indikator-pasienPindah');
    Route::get('/pindah/{id}/edit', [PasienPindahController::class, 'edit'])->name('edit.petugas_indikator-pasienPindah');
    Route::delete('/pindah/{id}', [PasienPindahController::class, 'destroy'])->name('delete.petugas_indikator-pasienPindah');
    Route::get('/pindah/{id}/sebelumnya', [PasienPindahController::class, 'getPasienPindahSebelumnya'])->name('perawat-pasienPindah.sebelumnya');

    // Route untuk pasien keluar
    Route::post('/keluar', [PasienKeluarController::class, 'store'])->name('store.petugas_indikator-pasienKeluar');
    Route::put('/keluar/{id}', [PasienKeluarController::class, 'update'])->name('update.petugas_indikator-pasienKeluar');
    Route::get('/keluar/{id}/edit', [PasienKeluarController::class, 'edit'])->name('edit.petugas_indikator-pasienKeluar');
    Route::delete('/keluar/{id}', [PasienKeluarController::class, 'destroy'])->name('delete.petugas_indikator-pasienKeluar');
});

// Route untuk data bangsal
Route::prefix('/petugas_indikator/data-bangsal')->middleware(['auth.login', 'role:petugas_indikator'])->group(function () {
    // Route Testing get untuk menu data bangsal
    Route::get('/bangsal/chart-data', [BangsalController::class, 'getChartData'])->name('dataChart.dataBangsal');
    Route::get('/', [BangsalController::class, 'index'])->name('petugas_indikator.data-bangsal.index');
    Route::post('/', [BangsalController::class, 'store'])->name('store.dataBangsal');
    Route::put('/{id}', [BangsalController::class, 'update'])->name('update.dataBangsal');
    Route::get('/{id}/edit', [BangsalController::class, 'edit'])->name('edit.dataBangsal');
    Route::delete('/{id}', [BangsalController::class, 'destroy'])->name('delete.dataBangsal');
});

// Route untuk data kelas bangsal
Route::prefix('/petugas_indikator/data-kelas-bangsal')->middleware(['auth.login', 'role:petugas_indikator'])->group(function () {
    Route::post('/', [KelasBangsalController::class, 'store'])->name('store.kelasBangsal');
    Route::put('/{id}', [KelasBangsalController::class, 'update'])->name('update.kelasBangsal');
    Route::get('/{id}/edit', [KelasBangsalController::class, 'edit'])->name('edit.kelasBangsal');
    Route::delete('/{id}', [KelasBangsalController::class, 'destroy'])->name('delete.kelasBangsal');
});

// Route untuk data pasien masuk
Route::prefix('/perawat/data-pasien-masuk')->middleware(['auth.login', 'role:perawat'])->group(function () {
    // Route untuk testing panggil index pada pasien masuk
    Route::get('/', [PasienMasukController::class, 'index'])->name('perawat-pasienMasuk.index');
    Route::post('/', [PasienMasukController::class, 'store'])->name('store.perawat-pasienMasuk');
    Route::put('/{id}', [PasienMasukController::class, 'update'])->name('update.perawat-pasienMasuk');
    Route::get('/{id}/edit', [PasienMasukController::class, 'edit'])->name('edit.perawat-pasienMasuk');
    Route::delete('/{id}', [PasienMasukController::class, 'destroy'])->name('delete.perawat-pasienMasuk');
    // Route khusus untuk mengambil data pasien masuk sebelumnya
    Route::get('/{id}/setelah', [PasienMasukController::class, 'getPasienMasukSetelah'])->name('perawat-pasienMasuk.setelah');
});

// Route untuk data pasien keluar
Route::prefix('/perawat/data-pasien-keluar')->middleware(['auth.login', 'role:perawat'])->group(function () {
    // Route untuk testing panggil index pada pasien keluar
    Route::get('/', [PasienKeluarController::class, 'index'])->name('perawat-pasienKeluar.index');
    Route::post('/', [PasienKeluarController::class, 'store'])->name('store.perawat-pasienKeluar');
    Route::put('/{id}', [PasienKeluarController::class, 'update'])->name('update.perawat-pasienKeluar');
    Route::get('/{id}/edit', [PasienKeluarController::class, 'edit'])->name('edit.perawat-pasienKeluar');
    Route::delete('/{id}', [PasienKeluarController::class, 'destroy'])->name('delete.perawat-pasienKeluar');
});

// Route untuk data pasien pindah
Route::prefix('/perawat/data-pasien-pindah')->middleware(['auth.login', 'role:perawat'])->group(function () {
    // Route untuk testing panggil index pada pasien pindah
    Route::get('/', [PasienPindahController::class, 'index'])->name('perawat-pasienPindah.index');
    Route::post('/', [PasienPindahController::class, 'store'])->name('store.perawat-pasienPindah');
    Route::put('/{id}', [PasienPindahController::class, 'update'])->name('update.perawat-pasienPindah');
    Route::get('/{id}/edit', [PasienPindahController::class, 'edit'])->name('edit.perawat-pasienPindah');
    Route::delete('/{id}', [PasienPindahController::class, 'destroy'])->name('delete.perawat-pasienPindah');
    // Route khusus untuk mengambil data pasien pindah sebelumnya
    Route::get('/{id}/sebelumnya', [PasienPindahController::class, 'getPasienPindahSebelumnya'])->name('perawat-pasienPindah.sebelumnya');
});

// Route untuk laporan (petugas indikator)
Route::prefix('/petugas_indikator/laporan')->middleware(['auth.login', 'role:petugas_indikator'])->group(function () {
    // Route untuk testing panggil index pada laporan
    Route::get('/', [LaporanController::class, 'index'])->name('petugas_indikator.laporan.index');
    Route::get('/rekapitulasi', [LaporanController::class, 'rekapitulasi'])->name('petugas_indikator.laporan.rekap');
    // Route untuk getData Rekapitulasi
    Route::get('/rekapitulasi/getData', [LaporanController::class, 'getDataRekapitulasi'])->name('petugas_indikator.laporan.getDataRekapitulasi');
});

// Route untuk perawat
Route::prefix('/petugas_indikator/perawat')->middleware(['auth.login', 'role:petugas_indikator'])->group(function () {
    // Route untuk testing panggil index pada perawat
    Route::get('/', [PerawatController::class, 'index'])->name('petugas_indikator.data-perawat.index');
    Route::post('/', [PerawatController::class, 'store'])->name('store.perawat');
    Route::put('/{id}', [PerawatController::class, 'update'])->name('update.perawat');
    Route::get('/{id}/edit', [PerawatController::class, 'edit'])->name('edit.perawat');
    Route::delete('/{id}', [PerawatController::class, 'destroy'])->name('delete.perawat');
});


// Route untuk testing
Route::get('/modelrs', [ModelRSController::class, 'index']);
Route::get('/modelrs/chart-data', [ModelRSController::class, 'getChartData']);

// Route untuk testing
Route::get('/testing', [Testing::class, 'cekTempatTidur']);