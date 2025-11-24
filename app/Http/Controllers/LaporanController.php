<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $jenis = $request->jenis ?? 'barang';

    // Filter umum
    $bulan   = $request->bulan;
    $tahun   = $request->tahun;
    $jurusan = $request->jurusan;
    $kondisi = $request->kondisi;

    // Default jurusanList
    $jurusanList = [];

    switch ($jenis) {
        case 'supplier':
            $data = Supplier::latest()->get();
            break;

        case 'barang_masuk':
            $data = BarangMasuk::with(['barang','supplier'])
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_masuk', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal_masuk', $tahun))
                ->latest()->get();
            break;

        case 'barang_keluar':
            $data = BarangKeluar::with('barang')
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_keluar', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal_keluar', $tahun))
                ->latest()->get();
            break;

        case 'peminjaman':
            $data = Peminjaman::with(['barang','user'])
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal_pinjam', $tahun))
                ->latest()->get();
            break;

        case 'barang_dihapus': // Tambahan baru
            $data = Barang::with('user')
                ->whereNotNull('tanggal_penghapusan') // Hanya yang sudah dihapus
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_penghapusan', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal_penghapusan', $tahun))
                ->when($jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $jurusan)))
                ->latest()->get();
            
            $jurusanList = Barang::with('user')
                ->whereNotNull('tanggal_penghapusan')
                ->get()
                ->pluck('user.jurusan')
                ->filter()
                ->unique()
                ->sort()
                ->values();
            break;

        default: // barang aktif
            $data = Barang::with('user')
                ->whereNull('tanggal_penghapusan')
                ->when($bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
                ->when($jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $jurusan)))
                ->when($kondisi, fn($q) => $q->where('kondisi', $kondisi))
                ->latest()->get();

            $jurusanList = Barang::with('user')
                ->whereNull('tanggal_penghapusan')
                ->get()
                ->pluck('user.jurusan')
                ->filter()
                ->unique()
                ->sort()
                ->values();
            break;
    }

    return view('admin.laporan.index', [
        'jenis'        => $jenis,
        'data'         => $data,
        'barang'       => $data,
        'jurusanList'  => $jurusanList,
    ]);
}


    public function exportPdf(Request $request)
    {
        $barang = Barang::with('user')
            ->whereNull('tanggal_penghapusan') // hanya barang aktif
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('barang'));
        return $pdf->download('laporan-barang.pdf');
    }

    public function exportExcel($jenis)
    {
        return Excel::download(new DynamicExport($jenis), "laporan-{$jenis}.xlsx");
    }
}
