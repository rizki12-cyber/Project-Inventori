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

    // Ambil barang berdasarkan kabeng login (user_id)
    $barangQuery = Barang::where('user_id', $user->id);

    // Tambahan filter (opsional)
    if ($request->filled('kategori')) {
        $barangQuery->where('kategori', $request->kategori);
    }

    if ($request->filled('kondisi')) {
        $barangQuery->where('kondisi', $request->kondisi);
    }

    // Ambil hasil
    $barang = $barangQuery->get();

    return view('kabeng.laporan', [
        'barang'   => $barang,
        'kategori' => $request->kategori,
    ]);
}


    public function export(Request $request)
    {
        $user = Auth::user();
        return Excel::download(
            new KabengBarangExport($user->id, $request->kategori, $request->kondisi),
            'laporan_barang_kabeng.xlsx'
        );
    }
}
