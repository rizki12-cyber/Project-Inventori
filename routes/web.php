<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KabengDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aplikasi Inventori Barang Sekolah (Laravel 12)
| Role utama: admin, wakasek, kabeng
|
*/

// ==========================
// 🔹 DEFAULT REDIRECT
// ==========================
Route::get('/', fn() => redirect()->route('login'));


// ==========================
// 🔹 AUTHENTICATION ROUTES
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// ✅ Logout harus pakai POST
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ==========================
// 🔹 ADMIN AREA
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::resource('barang', BarangController::class);
});


// ==========================
// 🔹 WAKASEK AREA
// ==========================
Route::middleware(['auth', 'role:wakasek'])->prefix('wakasek')->group(function () {
    Route::get('/dashboard', fn() => view('wakasek.dashboard'))->name('wakasek.dashboard');
    Route::get('/laporan', fn() => view('wakasek.laporan'))->name('wakasek.laporan');
    Route::get('/lihat-barang-kabeng', fn() => view('wakasek.lihat-barang-kabeng'))->name('wakasek.lihat.barang.kabeng');
});


// ==========================
// 🔹 KABENG AREA
// ==========================
// ==========================
// 🔹 KABENG AREA
// ==========================
Route::middleware(['auth', 'role:kabeng'])->prefix('kabeng')->group(function () {
    Route::get('/dashboard', function () {
        return view('kabeng.dashboard');
    })->name('kabeng.dashboard');
});

