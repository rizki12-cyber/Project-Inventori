<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WakasekBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin & Wakasek bisa lihat semua barang
        if (in_array($user->role, ['admin', 'wakasek'])) {
    $barang = Barang::latest()->get();
} else {
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
            'jumlah' => 'required|integer|min:0',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'sumber_dana' => 'nullable|string',
            'tanggal_penghapusan' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $validated['user_id'] = $user->id;

        // Kabeng otomatis pakai jurusan
        if ($user->role === 'kabeng') {
            $validated['jurusan'] = $user->programkeahlian?->nama_program;
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto_barang', $filename, 'public');
            $validated['foto'] = $filename;
        }

        Barang::create($validated);

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $user = Auth::user();

        // Kabeng cuma bisa edit barang miliknya sendiri
        if ($user->role === 'kabeng' && $barang->user_id != $user->id) {
            abort(403, 'Anda tidak diperbolehkan mengedit barang milik orang lain.');
        }

        return view('wakasek.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $user = Auth::user();

        if ($user->role === 'kabeng' && $barang->user_id != $user->id) {
            abort(403, 'Anda tidak diperbolehkan memperbarui barang milik orang lain.');
        }

        $validated = $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer|min:0',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'sumber_dana' => 'nullable|string',
            'tanggal_penghapusan' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            if ($barang->foto && Storage::exists('public/foto_barang/' . $barang->foto)) {
                Storage::delete('public/foto_barang/' . $barang->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto_barang', $filename, 'public');
            $validated['foto'] = $filename;
        }

        $barang->update($validated);

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $user = Auth::user();

        // Kabeng cuma bisa hapus barang miliknya
        if ($user->role === 'kabeng' && $barang->user_id != $user->id) {
            abort(403, 'Anda tidak diperbolehkan menghapus barang milik orang lain.');
        }

        // Wakasek tidak boleh hapus barang kabeng lain
        if ($user->role === 'wakasek' && $barang->user_id != $user->id) {
            abort(403, 'Wakasek tidak diperbolehkan menghapus barang milik kabeng.');
        }

        if ($barang->foto && Storage::exists('public/foto_barang/' . $barang->foto)) {
            Storage::delete('public/foto_barang/' . $barang->foto);
        }

        $barang->delete();

        return redirect()->route('wakasek.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    public function show(Barang $barang)
    {
        return view('wakasek.barang.detail', compact('barang'));
    }
}
