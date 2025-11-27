<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;

class LaporanWakasekController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user(); // Wakasek yang login

        $bulan   = $request->bulan;
        $tahun   = $request->tahun;
        $kondisi = $request->kondisi;
        $jenis   = $request->jenis;  // ← DITAMBAHKAN

        // ================= BARANG AKTIF =================
        $barangAktif = Barang::with('user')
            ->where('user_id', $user->id)
            ->whereNull('tanggal_penghapusan')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
            ->when($kondisi, fn($q) => $q->where('kondisi', $kondisi))
            ->latest()
            ->get();

        // ================= BARANG DIHAPUS =================
        $barangDihapus = Barang::with('user')
            ->where('user_id', $user->id)
            ->whereNotNull('tanggal_penghapusan')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_penghapusan', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_penghapusan', $tahun))
            ->latest()
            ->get();

        // Pilih data yang akan ditampilkan berdasarkan jenis laporan
        $data = $jenis == 'barang'
            ? $barangAktif
            : ($jenis == 'barang_dihapus' ? $barangDihapus : collect());

        return view('wakasek.laporan.index', compact(
            'barangAktif',
            'barangDihapus',
            'data',
            'bulan',
            'tahun',
            'kondisi',
            'jenis' // ← DITAMBAHKAN
        ));
    }

    // ==================== EXPORT EXCEL SAJA ====================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BarangExport($request),
            'laporan-barang-wakasek.xlsx'
        );
    }
}
