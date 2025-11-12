<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Tampilkan semua data barang berdasarkan role user.
     */
    public function index()
{
    $user = Auth::user();

    if (in_array($user->role, ['admin', 'wakasek'])) {
        // Admin & Wakasek bisa lihat semua barang
        $barang = Barang::latest()->get();
        $view = 'admin.barang.index';
    } elseif ($user->role === 'kabeng') {
        // Kabeng hanya lihat barang miliknya / jurusannya sendiri
        $barang = Barang::where('user_id', $user->id)
                        ->orWhere('jurusan', $user->jurusan)
                        ->latest()
                        ->get();
        $view = 'kabeng.barang.index';
    } else {
        abort(403, 'Anda tidak memiliki akses.');
    }

    return view($view, compact('barang'));
}


    /**
     * Form tambah barang.
     */
    public function create()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'kabeng'])) {
            abort(403, 'Anda tidak memiliki izin menambahkan barang.');
        }

        $view = $user->role === 'kabeng' ? 'kabeng.barang.create' : 'admin.barang.create';
        return view($view);
    }

    /**
     * Simpan barang baru.
     */
    public function store(Request $request)
{
    $user = Auth::user();

    if (!in_array($user->role, ['admin', 'kabeng'])) {
        abort(403, 'Anda tidak memiliki izin menambahkan barang.');
    }

    $validated = $request->validate([
        'kode_barang' => 'required|unique:barang',
        'nama_barang' => 'required',
        'kategori' => 'required',
        'jumlah' => 'required|integer|min:0',
        'kondisi' => 'required',
        'lokasi' => 'required',
        'tanggal_pembelian' => 'required|date',
        'keterangan' => 'nullable',
    ]);

    // Simpan user_id
    $validated['user_id'] = $user->role === 'kabeng' ? $user->id : ($request->user_id ?? $user->id);

    // Simpan barang dengan kode_barang dari input (tidak diubah)
    Barang::create($validated);

    $route = $user->role === 'kabeng' ? 'kabeng.barang.index' : 'admin.barang.index';
    return redirect()->route($route)->with('success', 'Barang berhasil ditambahkan.');
}


    /**
     * Form edit barang (hanya admin).
     */
    public function edit(Barang $barang)
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        return view('admin.barang.edit', compact('barang'));
    } elseif ($user->role === 'kabeng' && $barang->user_id == $user->id) {
        return view('kabeng.barang.edit', compact('barang'));
    }

    abort(403, 'Anda tidak memiliki izin untuk mengedit barang ini.');
}

public function update(Request $request, Barang $barang)
{
    $user = Auth::user();

    if (!in_array($user->role, ['admin', 'kabeng'])) {
        abort(403, 'Anda tidak memiliki izin untuk memperbarui barang ini.');
    }

    // kabeng cuma boleh update barang miliknya sendiri
    if ($user->role === 'kabeng' && $barang->user_id != $user->id) {
        abort(403, 'Anda tidak dapat memperbarui barang milik orang lain.');
    }

    $validated = $request->validate([
        'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
        'nama_barang' => 'required',
        'kategori' => 'required',
        'jumlah' => 'required|integer|min:0',
        'kondisi' => 'required',
        'lokasi' => 'required',
        'tanggal_pembelian' => 'required|date',
        'keterangan' => 'nullable',
    ]);

    $barang->update($validated);

    $redirect = $user->role === 'kabeng' ? 'kabeng.barang.index' : 'admin.barang.index';
    return redirect()->route($redirect)->with('success', 'Barang berhasil diperbarui.');
}

public function destroy(Barang $barang)
{
    $user = Auth::user();

    if ($user->role === 'admin' || ($user->role === 'kabeng' && $barang->user_id == $user->id)) {
        $barang->delete();

        $redirect = $user->role === 'kabeng' ? 'kabeng.barang.index' : 'admin.barang.index';
        return redirect()->route($redirect)->with('success', 'Barang berhasil dihapus.');
    }

    abort(403, 'Anda tidak memiliki izin untuk menghapus barang ini.');
}

}
