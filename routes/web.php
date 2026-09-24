<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['cekrole:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengguna
    Route::resource('/pengguna', PenggunaController::class)->except(['show']);

    // Tarif
    Route::resource('/tarif', TarifController::class)->except(['show']);

    // Area Parkir (URL: /area-parkir)
    Route::resource('/area-parkir', AreaParkirController::class)->except(['show'])->names('area');

    // Kendaraan (URL: /kendaraan)
    Route::resource('/kendaraan', KendaraanController::class)->except(['show']);

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');

});

/*
|--------------------------------------------------------------------------
| PETUGAS & ADMIN (Agar Admin juga bisa buka Transaksi)
|--------------------------------------------------------------------------
*/
Route::middleware(['cekrole:petugas,admin'])->group(function () {

    // Dashboard Petugas
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])->name('petugas.dashboard');

    // Parkir / Transaksi (URL: /transaksi)
    Route::resource('/transaksi', ParkirController::class)->except(['show'])->names('parkir');

    // Cetak Struk
    Route::get('/transaksi/{id}/struk', [ParkirController::class, 'struk'])->name('parkir.struk');

});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['cekrole:owner'])->group(function () {

    // Dashboard Owner
    Route::get('/owner/dashboard', [DashboardController::class, 'owner'])->name('owner.dashboard');

});

/*
|--------------------------------------------------------------------------
| JALUR KHUSUS REKAP / LAPORAN (BEBAS AKSES UNTUK TESTING)
|--------------------------------------------------------------------------
*/
// Sudah diganti menjadi /rekap agar pas dancok/cocok dengan tombol sidebar bos!
Route::get('/rekap', [LaporanController::class, 'index'])->name('laporan.index');
