<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WakasekBarangController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\LaporanWakasekController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;

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

    // 🧭 Dashboard
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

    // 🚚 Barang Masuk (fitur baru)
    Route::resource('barang-masuk', BarangMasukController::class)->names([
        'index'   => 'admin.barangmasuk.index',
        'create'  => 'admin.barangmasuk.create',
        'store'   => 'admin.barangmasuk.store',
        'edit'    => 'admin.barangmasuk.edit',
        'update'  => 'admin.barangmasuk.update',
        'destroy' => 'admin.barangmasuk.destroy',
        'show'    => 'admin.barangmasuk.show',
    ]);

    // 🚪 Barang Keluar (fitur baru)
    Route::resource('barang-keluar', BarangKeluarController::class)->names([
        'index'   => 'admin.barangkeluar.index',
        'create'  => 'admin.barangkeluar.create',
        'store'   => 'admin.barangkeluar.store',
        'edit'    => 'admin.barangkeluar.edit',
        'update'  => 'admin.barangkeluar.update',
        'destroy' => 'admin.barangkeluar.destroy',
        'show'    => 'admin.barangkeluar.show',
    ]);

    // 📊 Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export.excel');

    // 👤 Profil Admin
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // 👥 Data User
    Route::resource('datauser', DataUserController::class)->names([
        'index'   => 'admin.datauser.index',
        'create'  => 'admin.datauser.create',
        'store'   => 'admin.datauser.store',
        'edit'    => 'admin.datauser.edit',
        'update'  => 'admin.datauser.update',
        'destroy' => 'admin.datauser.destroy',
        'show'    => 'admin.datauser.show',
    ]);

    // 🚛 Supplier
    Route::resource('supplier', SupplierController::class)->names([
        'index'   => 'admin.supplier.index',
        'create'  => 'admin.supplier.create',
        'store'   => 'admin.supplier.store',
        'edit'    => 'admin.supplier.edit',
        'update'  => 'admin.supplier.update',
        'destroy' => 'admin.supplier.destroy',
        'show'    => 'admin.supplier.show',
    ]);

    // 📚 Peminjaman
    Route::resource('peminjaman', PeminjamanController::class)->names([
        'index'   => 'admin.peminjaman.index',
        'create'  => 'admin.peminjaman.create',
        'store'   => 'admin.peminjaman.store',
        'edit'    => 'admin.peminjaman.edit',
        'update'  => 'admin.peminjaman.update',
        'destroy' => 'admin.peminjaman.destroy',
    ]);
});


// ==========================
// 🔹 WAKASEK AREA
// ==========================
Route::middleware(['auth', 'role:wakasek'])->prefix('wakasek')->group(function () {
    Route::get('/dashboard', fn() => view('wakasek.dashboard'))->name('wakasek.dashboard');
    Route::get('/laporan', fn() => view('wakasek.laporan'))->name('wakasek.laporan');

    //laporan wakasek
    Route::get('/laporan', [LaporanwakasekController::class, 'index'])->name('wakasek.laporan.index');
    Route::get('/laporan/export/pdf', [LaporanWakasekController::class, 'exportPdf'])->name('wakasek.laporan.export.pdf');
    Route::get('/laporan/export/excel', [LaporanWakasekController::class, 'exportExcel'])->name('wakasek.laporan.export.excel');

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

    // 📦 CRUD Barang (Kabeng hanya bisa kelola barang miliknya)
    Route::get('/barang', [BarangController::class, 'index'])->name('kabeng.barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('kabeng.barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('kabeng.barang.store');

    // ✏️ Edit barang (hanya jika milik sendiri)
    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('kabeng.barang.edit');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('kabeng.barang.update');

    // ❌ Hapus barang (hanya jika milik sendiri)
    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('kabeng.barang.destroy');
});


