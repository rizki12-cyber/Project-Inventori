<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /** 🔹 Tampilkan daftar semua barang keluar */
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->latest()->get();
        return view('admin.BarangKeluar.index', compact('barangKeluar'));
    }

    /** 🔹 Tampilkan form tambah barang keluar */
    public function create()
    {
        $barang = Barang::all();
        return view('admin.BarangKeluar.create', compact('barang'));
    }

    /** 🔹 Simpan data barang keluar baru ke database */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'lokasi' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->jumlah < $request->jumlah) {
            return back()->with('error', 'Jumlah barang keluar melebihi stok yang tersedia!');
        }

        // Kurangi stok
        $barang->decrement('jumlah', $request->jumlah);

        // Simpan data barang keluar
        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah' => $request->jumlah,
            'lokasi' => $request->lokasi,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.barangkeluar.index')
            ->with('success', 'Data barang keluar berhasil ditambahkan!');
    }

    /** 🔹 Hapus data barang keluar */
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        // Kembalikan stok barang
        $barang = Barang::find($barangKeluar->barang_id);
        if ($barang) {
            $barang->increment('jumlah', $barangKeluar->jumlah);
        }

        $barangKeluar->delete();

        return redirect()->route('admin.barangkeluar.index')
            ->with('success', 'Data barang keluar berhasil dihapus!');
    }

    public function edit($id)
{
    $barangKeluar = BarangKeluar::findOrFail($id);
    $barang = Barang::all(); // untuk dropdown

    return view('admin.barangkeluar.edit', compact('barangKeluar', 'barang'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'id_barang' => 'required',
        'tanggal_keluar' => 'required|date',
        'jumlah' => 'required|integer|min:1',
        'lokasi' => 'nullable|string',
        'penerima' => 'nullable|string',
        'keterangan' => 'nullable|string',
    ]);

    $bk = BarangKeluar::findOrFail($id);

    $bk->update([
        'id_barang' => $request->id_barang,
        'tanggal_keluar' => $request->tanggal_keluar,
        'jumlah' => $request->jumlah,
        'lokasi' => $request->lokasi,
        'penerima' => $request->penerima,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('admin.barangkeluar.index')->with('success', 'Data berhasil diperbarui!');
}

}
