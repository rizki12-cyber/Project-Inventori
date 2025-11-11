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
        // Filter laporan berdasarkan bulan, tahun, jurusan, dan kondisi
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $jurusan = $request->jurusan;
        $kondisi = $request->kondisi;

        $barang = Barang::with('user')
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_pembelian', $tahun))
            ->when($jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $jurusan)))
            ->when($kondisi, fn($q) => $q->where('kondisi', $kondisi))
            ->latest()
            ->get();

        $jurusanList = ['TKR', 'TSM', 'PPLG', 'TKJ', 'AKL', 'BDP'];

        return view('wakasek.laporan.index', compact('barang', 'bulan', 'tahun', 'jurusan', 'kondisi', 'jurusanList'));
    }

    public function exportPdf(Request $request)
    {
        $barang = $this->getFilteredData($request);
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('barang'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-barang.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new BarangExport($request), 'laporan-barang.xlsx');
    }

    // Fungsi bantu untuk filter data
    private function getFilteredData($request)
    {
        return Barang::with('user')
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_pembelian', $request->tahun))
            ->when($request->jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $request->jurusan)))
            ->when($request->kondisi, fn($q) => $q->where('kondisi', $request->kondisi))
            ->latest()
            ->get();
    }
}
