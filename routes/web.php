<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WakasekBarangController;
use App\Http\Controllers\DataUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aplikasi Inventori Barang Sekolah (Laravel 12)
| Role utama: admin, wakasek, kabeng
|--------------------------------------------------------------------------
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

// ✅ Logout (POST)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ==========================
// 🔹 ADMIN AREA
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // 📦 Barang CRUD
    Route::resource('barang', BarangController::class)->names([
        'index'   => 'admin.barang.index',
        'create'  => 'admin.barang.create',
        'store'   => 'admin.barang.store',
        'edit'    => 'admin.barang.edit',
        'update'  => 'admin.barang.update',
        'destroy' => 'admin.barang.destroy',
        'show'    => 'admin.barang.show',
    ]);

    // 📊 Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export.excel');

    // 👤 Profil Admin
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // 👥 Data User (fitur baru)
    Route::resource('datauser', DataUserController::class)->names([
        'index'   => 'admin.datauser.index',
        'create'  => 'admin.datauser.create',
        'store'   => 'admin.datauser.store',
        'edit'    => 'admin.datauser.edit',
        'update'  => 'admin.datauser.update',
        'destroy' => 'admin.datauser.destroy',
        'show'    => 'admin.datauser.show',
    ]);
});


// ==========================
// 🔹 WAKASEK AREA
// ==========================
Route::middleware(['auth', 'role:wakasek'])->prefix('wakasek')->group(function () {
    Route::get('/dashboard', fn() => view('wakasek.dashboard'))->name('wakasek.dashboard');
    Route::get('/laporan', fn() => view('wakasek.laporan'))->name('wakasek.laporan');

    // 📦 Barang CRUD untuk wakasek
    Route::resource('barang', WakasekBarangController::class)->names([
        'index'   => 'wakasek.barang.index',
        'create'  => 'wakasek.barang.create',
        'store'   => 'wakasek.barang.store',
        'edit'    => 'wakasek.barang.edit',
        'update'  => 'wakasek.barang.update',
        'destroy' => 'wakasek.barang.destroy',
        'show'    => 'wakasek.barang.show',
    ]);
});


// ==========================
// 🔹 KABENG AREA
// ==========================
Route::middleware(['auth', 'role:kabeng'])->prefix('kabeng')->group(function () {
    Route::get('/dashboard', fn() => view('kabeng.dashboard'))->name('kabeng.dashboard');
});
