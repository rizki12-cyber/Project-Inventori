<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
    {
        public function index()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])->latest()->get();
        return view('admin.BarangMasuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barang = Barang::all();
        $suppliers = Supplier::all();
        return view('admin.BarangMasuk.create', compact('barang', 'suppliers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        BarangMasuk::create($request->all());

        // update stok barang (opsional)
        $barang = Barang::find($request->id_barang);
        $barang->stok += $request->jumlah;
        $barang->save();

        return redirect()->route('admin.barangmasuk.index')->with('success', 'Data barang masuk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id)
{
    $barangMasuk = BarangMasuk::findOrFail($id);
    $barang = Barang::all();
    $suppliers = Supplier::all();

    return view('admin.BarangMasuk.edit', compact('barangMasuk', 'barang', 'suppliers'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'id_supplier' => 'required|exists:suppliers,id',
        'tanggal_masuk' => 'required|date',
        'jumlah' => 'required|integer|min:1',
    ]);

    $bm = BarangMasuk::findOrFail($id);

    // hitung perubahan stok
    $selisih = $request->jumlah - $bm->jumlah;

    // update barang masuk
    $bm->update($request->all());

    // update stok barang
    $barang = Barang::find($request->id_barang);
    $barang->stok += $selisih;
    $barang->save();

    return redirect()->route('admin.barangmasuk.index')
        ->with('success', 'Data barang masuk berhasil diperbarui!');
}

}
