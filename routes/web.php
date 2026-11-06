<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


Route::get('/home', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('beranda');
});

Route::get('/dashboard', function () {
    return view('dashboard/user');
})->middleware('auth');

Route::get('/absen', function () {
    return view('absensi');
});

Route::get('/riwayat', function () {
    return view('riwayat');
});
