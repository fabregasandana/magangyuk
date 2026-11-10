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

Route::get('/izin', function () {
    return view('feature/izin');
});

Route::get('/profil', function () {
    return view('feature/profil');
});

Route::get('/logbook', function () {
    return view('feature/logbook');
});

Route::get('/laporanbimbingan', function () {
    return view('feature/laporanbimbingan');
});

Route::get('/profile', function () {
    return view('feature/profile');
});

Route::get('/peserta', function () {
    return view('feature/peserta');
});

Route::get('/detailpeserta', function () {
    return view('feature/detailpeserta');
});

Route::get('/dashboardpembimbing', function () {
    return view('dashboard/pembimbing');
});

Route::get('/penilaianpeserta', function () {
    return view('feature/penilaianpeserta');
});

Route::get('/admin', function () {
    return view('dashboard/admin');
});

Route::get('/manajemen', function () {
    return view('feature/manajemenpeserta');
});

Route::get('/manajemen', function () {
    return view('feature/manajemenpembimbing');
});

Route::get('/monitoring', function () {
    return view('feature/monitoringkinerja');
});

Route::get('/kelolapenilaian', function () {
    return view('feature/kelolapenilaian');
});

Route::get('/cms', function () {
    return view('feature/cms');
});

