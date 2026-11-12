<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PembimbingPageController;
use App\Http\Controllers\PesertaPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing page (publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| PESERTA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:peserta'])->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaPageController::class, 'dashboard'])->name('dashboard');

    Route::get('/absen', [PesertaPageController::class, 'absensi'])->name('absensi');
    Route::post('/absen', [PesertaPageController::class, 'storeAbsen'])->name('absen.store');

    Route::get('/riwayat', [PesertaPageController::class, 'riwayat'])->name('riwayat');
    Route::get('/grafik', [PesertaPageController::class, 'grafik'])->name('grafik');
    Route::get('/penilaian', [PesertaPageController::class, 'penilaian'])->name('penilaian');

    Route::get('/laporan', [PesertaPageController::class, 'laporan'])->name('laporan');
    Route::post('/laporan', [PesertaPageController::class, 'storeLaporan'])->name('laporan.store');

    Route::get('/sertifikat', [PesertaPageController::class, 'sertifikat'])->name('sertifikat');

    Route::get('/izin', [PesertaPageController::class, 'izin'])->name('izin');
    Route::post('/izin', [PesertaPageController::class, 'storeIzin'])->name('izin.store');

    Route::get('/profil', [PesertaPageController::class, 'profil'])->name('profil');
});

/*
|--------------------------------------------------------------------------
| PEMBIMBING
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembimbing'])->name('pembimbing.')->group(function () {
    Route::get('/dashboardpembimbing', [PembimbingPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/peserta', [PembimbingPageController::class, 'peserta'])->name('peserta');
    Route::get('/detailpeserta/{peserta?}', [PembimbingPageController::class, 'detailPeserta'])
        ->whereNumber('peserta')
        ->name('detailpeserta');
    Route::get('/penilaianpeserta', [PembimbingPageController::class, 'penilaianPeserta'])->name('penilaianpeserta');
    Route::get('/logbook', [PembimbingPageController::class, 'logbook'])->name('logbook');
    Route::get('/laporanbimbingan', [PembimbingPageController::class, 'laporanBimbingan'])->name('laporanbimbingan');
    Route::get('/profile', [PembimbingPageController::class, 'profile'])->name('profile');

    Route::post('/penilaianpeserta', [PembimbingPageController::class, 'simpanPenilaian'])->name('penilaian.store');
    Route::post('/logbook/review', [PembimbingPageController::class, 'reviewLogbook'])->name('logbook.review');
    Route::post('/laporan/review', [PembimbingPageController::class, 'reviewLaporan'])->name('laporan.review');
    Route::post('/izin/review', [PembimbingPageController::class, 'reviewIzin'])->name('izin.review');
    Route::post('/profile', [PembimbingPageController::class, 'simpanProfil'])->name('profile.update');
    Route::post('/profile/password', [PembimbingPageController::class, 'gantiPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminPageController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/manajemen', [AdminPageController::class, 'manajemenPeserta'])->name('admin.manajemen-peserta');
    Route::get('/manajemenpembimbing', [AdminPageController::class, 'manajemenPembimbing'])->name('admin.manajemen-pembimbing');
    Route::get('/monitoring', [AdminPageController::class, 'monitoring'])->name('admin.monitoring');
    Route::get('/kelolapenilaian', [AdminPageController::class, 'kelolaPenilaian'])->name('admin.kelola-penilaian');
    Route::get('/cms', [AdminPageController::class, 'cms'])->name('admin.cms');
    Route::get('/featurependukung', [AdminPageController::class, 'featurePendukung'])->name('admin.feature-pendukung');

    Route::name('admin.')->group(function () {
        // Peserta
        Route::post('/admin/peserta/store', [AdminPageController::class, 'storePeserta'])->name('peserta.store');
        Route::post('/admin/peserta/update', [AdminPageController::class, 'updatePeserta'])->name('peserta.update');
        Route::post('/admin/peserta/toggle', [AdminPageController::class, 'togglePeserta'])->name('peserta.toggle');
        Route::post('/admin/peserta/delete', [AdminPageController::class, 'destroyPeserta'])->name('peserta.delete');
        Route::post('/admin/peserta/assign', [AdminPageController::class, 'assignPeserta'])->name('peserta.assign');
        Route::post('/admin/peserta/import', [AdminPageController::class, 'importPeserta'])->name('peserta.import');
        Route::post('/admin/peserta/export', [AdminPageController::class, 'exportPeserta'])->name('peserta.export');

        // Pembimbing
        Route::post('/admin/pembimbing/store', [AdminPageController::class, 'storePembimbing'])->name('pembimbing.store');
        Route::post('/admin/pembimbing/update', [AdminPageController::class, 'updatePembimbing'])->name('pembimbing.update');
        Route::post('/admin/pembimbing/toggle', [AdminPageController::class, 'togglePembimbing'])->name('pembimbing.toggle');
        Route::post('/admin/pembimbing/delete', [AdminPageController::class, 'destroyPembimbing'])->name('pembimbing.delete');
        Route::post('/admin/pembimbing/assign', [AdminPageController::class, 'assignPembimbing'])->name('pembimbing.assign');
        Route::post('/admin/pembimbing/unassign', [AdminPageController::class, 'unassignPembimbing'])->name('pembimbing.unassign');

        // Monitoring
        Route::post('/admin/monitoring/export', [AdminPageController::class, 'exportLaporan'])->name('monitoring.export');

        // Penilaian
        Route::post('/admin/penilaian/kriteria/store', [AdminPageController::class, 'storeKriteria'])->name('kriteria.store');
        Route::post('/admin/penilaian/kriteria/delete', [AdminPageController::class, 'destroyKriteria'])->name('kriteria.delete');
        Route::post('/admin/penilaian/override', [AdminPageController::class, 'overridePenilaian'])->name('penilaian.override');

        // CMS
        Route::post('/admin/cms/store', [AdminPageController::class, 'storeCms'])->name('cms.store');
        Route::post('/admin/cms/delete', [AdminPageController::class, 'destroyCms'])->name('cms.delete');

        // Fitur pendukung
        Route::post('/admin/feature/store', [AdminPageController::class, 'storeFeature'])->name('feature.store');
        Route::post('/admin/feature/delete', [AdminPageController::class, 'destroyFeature'])->name('feature.delete');
        Route::post('/admin/feature/export-log', [AdminPageController::class, 'exportLog'])->name('feature.export-log');
        Route::post('/admin/pengaturan/store', [AdminPageController::class, 'storePengaturan'])->name('pengaturan.store');
    });
});
