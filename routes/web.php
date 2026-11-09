<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return view('index');
});

//HALAMAN PESERTA
Route::get('/dashboard', function () {
    return view('dashboard.user');
})->middleware('auth');

Route::get('/absen', function () {
    return view('fitur_peserta/absensi');
});

Route::get('/riwayat', function () {
    return view('fitur_peserta/riwayat');
});

Route::get('/grafik', function () {
    return view('fitur_peserta/grafik');
});

Route::get('/penilaian', function () {
    return view('fitur_peserta/penilaian');
});

Route::get('/laporan', function () {
    return view('fitur_peserta/laporan');
});

Route::get('/sertifikat', function () {
    return view('fitur_peserta/sertifikat');
});

Route::get('/izin', function () {
    return view('fitur_peserta/izin');
});

Route::get('/profil', function () {
    return view('fitur_peserta/profil');
});



// HALAMAN PEMBIMBING
Route::get('/dashboardpembimbing', function () {
    return view('dashboard/pembimbing');
});

Route::get('/logbook', function () {
    return view('fitur_pembimbing/logbook');
});

Route::get('/laporanbimbingan', function () {
    return view('fitur_pembimbing/laporanbimbingan');
});

Route::get('/profile', function () {
    return view('fitur_pembimbing/profile');
});

Route::get('/peserta', function () {
    return view('fitur_pembimbing/peserta');
});

Route::get('/detailpeserta', function () {
    return view('fitur_pembimbing/detailpeserta');
});


Route::get('/penilaianpeserta', function () {
    return view('fitur_pembimbing/penilaianpeserta');
});
