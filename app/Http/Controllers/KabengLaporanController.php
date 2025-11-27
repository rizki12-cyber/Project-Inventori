<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KabengBarangExport;

class KabengLaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil filter dari request
        $jenis = $request->get('jenis', null); // default null → halaman kosong
        $bulan = $request->get('bulan', null);
        $tahun = $request->get('tahun', null);
        $kondisi = $request->get('kondisi', null);

        $data = collect(); // default data kosong

        if ($jenis) {
            // ---------------------------------------------------------
            // QUERY BARANG AKTIF
            // ---------------------------------------------------------
            $barangAktif = Barang::where('user_id', $user->id)
                ->whereNull('tanggal_penghapusan');

            // ---------------------------------------------------------
            // QUERY BARANG DIHAPUS
            // ---------------------------------------------------------
            $barangDihapus = Barang::where('user_id', $user->id)
                ->whereNotNull('tanggal_penghapusan');

            // ---------------------------------------------------------
            // FILTER (BERLAKU UNTUK KEDUA QUERY)
            // ---------------------------------------------------------
            if ($bulan) {
                $barangAktif->whereMonth('tanggal_pembelian', $bulan);
                $barangDihapus->whereMonth('tanggal_pembelian', $bulan);
            }

            if ($tahun) {
                $barangAktif->whereYear('tanggal_pembelian', $tahun);
                $barangDihapus->whereYear('tanggal_pembelian', $tahun);
            }

            if ($kondisi) {
                $barangAktif->where('kondisi', $kondisi);
                // Barang dihapus bisa tidak difilter kondisi
            }

            // Pilih data sesuai jenis laporan
            $data = $jenis === 'barang_dihapus' ? $barangDihapus->get() : $barangAktif->get();
        }

        return view('kabeng.laporan', [
            'jenis' => $jenis,
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kondisi' => $kondisi,
        ]);
    }

    public function export(Request $request)
    {
        // Kirim **objek $request** ke export agar bisa pakai semua filter dan jenis laporan
        return Excel::download(
            new KabengBarangExport($request),
            'laporan_barang_kabeng.xlsx'
        );
    }
}
