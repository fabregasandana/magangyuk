<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('beranda');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard/user');
});

Route::get('/absen', function () {
    return view('absensi');
});

Route::get('/riwayat', function () {
    return view('riwayat');
});

Route::get('/grafik', function () {
    return view('grafik');
});

Route::get('/penilaian', function () {
    return view('penilaian');
});

Route::get('/laporan', function () {
    return view('laporan');
});

Route::get('/sertifikat', function () {
    return view('sertifikat');
});
