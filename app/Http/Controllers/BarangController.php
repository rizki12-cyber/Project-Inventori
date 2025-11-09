<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // 🔹 Admin lihat semua barang
        if ($user->role === 'admin') {
            $barang = Barang::latest()->get();
        } 
        // 🔹 Wakasek & Kabeng hanya lihat barang miliknya
        else {
            $barang = Barang::where('user_id', $user->id)->latest()->get();
        }

        return view('admin.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barang',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        // 🔹 Tambahkan user_id otomatis
        $validated['user_id'] = Auth::id();

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('admin.barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}
