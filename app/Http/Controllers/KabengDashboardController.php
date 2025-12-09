<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class KabengDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Total barang milik Kabeng
        $totalBarang = Barang::where('user_id', $userId)->count();

        // Grafik kategori
        $kategoriDataRaw = Barang::where('user_id', $userId)
                                ->selectRaw('kategori, COUNT(*) as total')
                                ->groupBy('kategori')
                                ->get();

        $kategoriLabels = $kategoriDataRaw->pluck('kategori');
        $kategoriData = $kategoriDataRaw->pluck('total');

        return view('kabeng.dashboard', compact(
            'totalBarang',
            'kategoriLabels',
            'kategoriData'
        ));
    }
}
