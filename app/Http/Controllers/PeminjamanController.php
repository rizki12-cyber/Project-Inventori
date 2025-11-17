<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class PeminjamanController extends Controller
{
    // Tampilkan daftar peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with('barang')->latest()->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $barangs = Barang::all();
        return view('admin.peminjaman.create', compact('barangs'));
    }

    // Simpan data peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'kondisi' => 'nullable|string|max:255',
        ]);

        // Status otomatis Dipinjam
        Peminjaman::create(array_merge($request->all(), ['status' => 'Dipinjam']));

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    // Form edit peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        $barangs = Barang::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    // Update peminjaman
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'kondisi' => 'nullable|string|max:255',
            'status' => 'required|in:Dipinjam,Dikembalikan',
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    // Hapus peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    // Ubah status menjadi Dikembalikan
    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'Dipinjam') {
            $peminjaman->update(['status' => 'Dikembalikan']);
            return redirect()->route('admin.peminjaman.index')
                             ->with('success', 'Status berhasil diubah menjadi Dikembalikan!');
        }

        return redirect()->route('admin.peminjaman.index')
                         ->with('info', 'Peminjaman sudah dikembalikan sebelumnya.');
    }

    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'peminjaman.xlsx');
    }
}
