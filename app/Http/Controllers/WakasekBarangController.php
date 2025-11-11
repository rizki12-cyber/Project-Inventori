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

        if (in_array($user->role, ['admin', 'wakasek'])) {
            // Admin & Wakasek bisa lihat semua barang
            $barang = Barang::latest()->get();
        } else {
            // Kabeng cuma lihat barang yang dia input sendiri
            $barang = Barang::where('user_id', $user->id)->latest()->get();
        }

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

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $user = Auth::user();

        // Kabeng cuma bisa edit barang miliknya sendiri
        if ($user->role === 'kabeng' && $barang->user_id !== $user->id) {
            abort(403, 'Anda tidak diperbolehkan mengedit barang milik orang lain.');
        }

        // Wakasek & Admin boleh lihat tapi tidak boleh ubah barang kabeng lain
        if (in_array($user->role, ['wakasek', 'admin']) && $barang->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Wakasek tidak diperbolehkan mengedit barang milik kabeng.');
        }

        return view('wakasek.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $user = Auth::user();

        // Kabeng cuma bisa update barang miliknya sendiri
        if ($user->role === 'kabeng' && $barang->user_id !== $user->id) {
            abort(403, 'Anda tidak diperbolehkan mengupdate barang milik orang lain.');
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
            ->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        $user = Auth::user();

        // Kabeng cuma bisa hapus barang miliknya sendiri
        if ($user->role === 'kabeng' && $barang->user_id !== $user->id) {
            abort(403, 'Anda tidak diperbolehkan menghapus barang milik orang lain.');
        }

        // Wakasek gak boleh hapus barang kabeng
        if ($user->role === 'wakasek' && $barang->user_id !== $user->id) {
            abort(403, 'Wakasek tidak diperbolehkan menghapus barang milik kabeng.');
        }

        $barang->delete();

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
