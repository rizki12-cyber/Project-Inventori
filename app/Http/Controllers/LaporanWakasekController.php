<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;

class LaporanWakasekController extends Controller
{
    public function index(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $kondisi = $request->kondisi;
    $jurusan = $request->jurusan;

    // Ambil daftar jurusan unik dari user wakasek
    $jurusanList = \App\Models\User::where('role', 'wakasek')
        ->pluck('jurusan')
        ->unique()
        ->filter()
        ->values();

    $barang = Barang::with('user')
        ->whereHas('user', fn($u) => $u->where('role', 'wakasek'))
        ->when($bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $bulan))
        ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
        ->when($jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $jurusan)))
        ->when($kondisi, fn($q) => $q->where('kondisi', $kondisi))
        ->latest()
        ->get();

    return view('wakasek.laporan.index', compact('barang', 'bulan', 'tahun', 'kondisi', 'jurusanList'));
}


    public function exportPdf(Request $request)
    {
        $barang = $this->getFilteredData($request);

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('barang'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new BarangExport($request), 'laporan-barang.xlsx');
    }

    private function getFilteredData($request)
    {
        return Barang::with('user')
            ->whereHas('user', fn($u) => $u->where('role', 'wakasek')) // ← WAJIB ADA
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_pembelian', $request->tahun))
            ->when($request->kondisi, fn($q) => $q->where('kondisi', $request->kondisi))
            ->latest()
            ->get();
    }
}
