<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard/user');
});

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