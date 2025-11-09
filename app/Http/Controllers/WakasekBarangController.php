<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class WakasekBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin lihat semua, wakasek lihat miliknya
        $barang = $user->role === 'admin'
            ? Barang::latest()->get()
            : Barang::where('user_id', $user->id)->latest()->get();

        return view('wakasek.barang.index', compact('barang'));
    }

    public function create()
    {
        return view('wakasek.barang.create');
    }

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

        $validated['user_id'] = Auth::id();

        Barang::create($validated);

        // pakai route nama wakasek
        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        if (Auth::user()->role !== 'admin' && $barang->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        return view('wakasek.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        if (Auth::user()->role !== 'admin' && $barang->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

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

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        if (Auth::user()->role !== 'admin' && $barang->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        $barang->delete();

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}
