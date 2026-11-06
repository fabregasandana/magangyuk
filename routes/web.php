<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


Route::get('/home', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard/user');
})->middleware('auth');

Route::get('/absen', function () {
    return view('feature/absensi');
});

Route::get('/riwayat', function () {
    return view('feature/riwayat');
});

Route::get('/grafik', function () {
    return view('feature/grafik');
});

Route::get('/penilaian', function () {
    return view('feature/penilaian');
});

Route::get('/laporan', function () {
    return view('feature/laporan');
});

Route::get('/sertifikat', function () {
    return view('feature/sertifikat');
});

Route::get('/izin', function () {
    return view('feature/izin');
});

Route::get('/profil', function () {
    return view('feature/profil');
});