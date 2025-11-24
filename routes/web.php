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
use App\Http\Controllers\ProgramKeahlianController;
use App\Http\Controllers\KonsentrasiKeahlianController;
use App\Http\Controllers\WakasekProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileKabengController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\KabengLaporanController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('admin.pengaturan.update');



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

    // 🚚 Barang Masuk
    Route::resource('barang-masuk', BarangMasukController::class)->names([
        'index'   => 'admin.barangmasuk.index',
        'create'  => 'admin.barangmasuk.create',
        'store'   => 'admin.barangmasuk.store',
        'edit'    => 'admin.barangmasuk.edit',
        'update'  => 'admin.barangmasuk.update',
        'destroy' => 'admin.barangmasuk.destroy',
        'show'    => 'admin.barangmasuk.show',
    ]);

    Route::get('/admin/barangmasuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('admin.barangmasuk.edit');


    // 🚪 Barang Keluar
    Route::resource('barang-keluar', BarangKeluarController::class)->names([
        'index'   => 'admin.barangkeluar.index',
        'create'  => 'admin.barangkeluar.create',
        'store'   => 'admin.barangkeluar.store',
        'edit'    => 'admin.barangkeluar.edit',
        'update'  => 'admin.barangkeluar.update',
        'destroy' => 'admin.barangkeluar.destroy',
        'show'    => 'admin.barangkeluar.show',
    ]);

    Route::get('/admin/barang/{barang}/detail', [BarangController::class, 'show'])->name('admin.barang.show');

    // Barang Keluar
Route::get('/admin/barangkeluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('admin.barangkeluar.edit');
Route::put('/admin/barangkeluar/{id}', [BarangKeluarController::class, 'update'])->name('admin.barangkeluar.update');


   // 📊 Laporan Utama
Route::get('/laporan', [LaporanController::class, 'index'])
->name('admin.laporan.index');

// 📤 Export PDF (opsional untuk barang saja)
Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])
->name('admin.laporan.export.pdf');

// 📥 Export Excel untuk semua jenis laporan
Route::get('/laporan/export/{jenis}', [LaporanController::class, 'exportExcel'])
->name('admin.laporan.export.excel');


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

Route::patch('admin/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('admin.peminjaman.kembalikan');


    // 🎓 Program Keahlian
    Route::resource('programkeahlian', ProgramKeahlianController::class)->names([
        'index'   => 'admin.programkeahlian.index',
        'create'  => 'admin.programkeahlian.create',
        'store'   => 'admin.programkeahlian.store',
        'edit'    => 'admin.programkeahlian.edit',
        'update'  => 'admin.programkeahlian.update',
        'destroy' => 'admin.programkeahlian.destroy',
    ]);

    // 🧩 Konsentrasi Keahlian (fitur baru)
    Route::resource('konsentrasikeahlian', KonsentrasiKeahlianController::class)->names([
        'index'   => 'admin.konsentrasi.index',
        'create'  => 'admin.konsentrasi.create',
        'store'   => 'admin.konsentrasi.store',
        'edit'    => 'admin.konsentrasi.edit',
        'update'  => 'admin.konsentrasi.update',
        'destroy' => 'admin.konsentrasi.destroy',
        'show'    => 'admin.konsentrasi.show',
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

    // Detail Barang Wakasek (opsional URL /detail)
Route::get('/barang/{barang}/detail', [WakasekBarangController::class, 'show'])->name('wakasek.barang.detail');


        Route::get('/wakasek/profile', [WakasekProfileController::class, 'index'])->name('wakasek.profile');
        Route::put('/wakasek/profile/update', [WakasekProfileController::class, 'update'])->name('wakasek.profile.update');
});
// ==========================
// 🔹 ADMIN AREA
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // route admin di sini
});


// ==========================
// 🔹 KABENG AREA
// ==========================
Route::middleware(['auth', 'role:kabeng'])->prefix('kabeng')->group(function () {
    Route::get('/dashboard', fn() => view('kabeng.dashboard'))->name('kabeng.dashboard');

    Route::get('/barang', [BarangController::class, 'index'])->name('kabeng.barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('kabeng.barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('kabeng.barang.store');

    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('kabeng.barang.edit');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('kabeng.barang.update');

    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('kabeng.barang.destroy');

    Route::get('/barang/{barang}/detail', [BarangController::class, 'show'])->name('kabeng.barang.show');

    // PROFIL KABENG
    Route::get('/profile', [ProfileKabengController::class, 'index'])->name('kabeng.profile.index');
    Route::post('/profile/update', [ProfileKabengController::class, 'update'])->name('kabeng.profile.update');

    Route::get('/laporan', [KabengLaporanController::class, 'index'])->name('kabeng.laporan');
    Route::get('/kabeng/laporan/export/excel', [KabengLaporanController::class, 'export'])
    ->name('kabeng.laporan.export');

});



