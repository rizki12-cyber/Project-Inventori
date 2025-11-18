<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use App\Models\Supplier;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan ringkasan data.
     */
    public function index()
    {
        // Hitung total barang
        $totalBarang       = Barang::count();

        // Hitung total barang masuk
        $totalBarangMasuk  = BarangMasuk::count();

        // Hitung total barang keluar
        $totalBarangKeluar = BarangKeluar::count();

        // Hitung total supplier
        $totalSupplier     = Supplier::count();

        // Hitung total peminjaman yang masih dipinjam
        $totalPeminjaman   = Peminjaman::where('status', 'dipinjam')->count();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalBarang', 
            'totalBarangMasuk', 
            'totalBarangKeluar', 
            'totalSupplier', 
            'totalPeminjaman'
        ));
    }
}
