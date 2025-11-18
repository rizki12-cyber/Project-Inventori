<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Tampilkan semua data barang berdasarkan role user.
     */
    public function index()
{
    $user = Auth::user();

    // Admin lihat semua + bisa edit hapus
    if ($user->role === 'admin') {
        $barang = Barang::latest()->get();
        return view('admin.barang.index', compact('barang'));
    }

    // Wakasek hanya lihat semua barang
    if ($user->role === 'wakasek') {
        $barang = Barang::latest()->get();
        return view('wakasek.barang.index', compact('barang'));
    }

    // Kabeng lihat barang sesuai jurusan/konsentrasi
    if ($user->role === 'kabeng') {
    $barang = Barang::where('user_id', $user->id)->latest()->get();
    return view('kabeng.barang.index', compact('barang'));
}


    abort(403, "Role tidak dikenali");
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
        'keterangan' => 'nullable|string',
        'spesifikasi' => 'nullable|string',
        'sumber_dana' => 'nullable|string',
        'tanggal_penghapusan' => 'nullable|date',
        'foto' => 'nullable|image|max:2048',
    ]);

    // User ID
    $validated['user_id'] = $user->id;

    // Inject jurusan otomatis untuk kabeng
    if ($user->role === 'kabeng') {
        $validated['jurusan'] = $user->programkeahlian?->nama_program;
    }

    // Admin boleh pilih jurusan manual
    if ($user->role === 'admin') {
        $validated['jurusan'] = $request->jurusan;
    }

    // Upload foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('foto_barang', $filename, 'public');
        $validated['foto'] = $filename;
    }

    Barang::create($validated);

    $route = $user->role === 'kabeng' 
        ? 'kabeng.barang.index' 
        : 'admin.barang.index';

    return redirect()->route($route)->with('success', 'Barang berhasil ditambahkan.');
}


    /**
     * Form edit barang.
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

    /**
     * Update barang.
     */
    public function update(Request $request, Barang $barang)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'kabeng'])) {
            abort(403, 'Anda tidak memiliki izin memperbarui barang ini.');
        }

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
            'keterangan' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'sumber_dana' => 'nullable|string',
            'tanggal_penghapusan' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($barang->foto && Storage::exists('public/foto_barang/' . $barang->foto)) {
                Storage::delete('public/foto_barang/' . $barang->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            // 🚀 FIX PATH
            $file->storeAs('foto_barang', $filename, 'public');

            $validated['foto'] = $filename;
        }

        $barang->update($validated);

        $redirect = $user->role === 'kabeng' ? 'kabeng.barang.index' : 'admin.barang.index';
        return redirect()->route($redirect)->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Hapus barang.
     */
    public function destroy(Barang $barang)
    {
        $user = Auth::user();

        if ($user->role === 'admin' || ($user->role === 'kabeng' && $barang->user_id == $user->id)) {

            // Hapus foto dari storage
            if ($barang->foto && Storage::exists('public/foto_barang/' . $barang->foto)) {
                Storage::delete('public/foto_barang/' . $barang->foto);
            }

            $barang->delete();

            $redirect = $user->role === 'kabeng' ? 'kabeng.barang.index' : 'admin.barang.index';
            return redirect()->route($redirect)->with('success', 'Barang berhasil dihapus.');
        }

        abort(403, 'Anda tidak memiliki izin menghapus barang ini.');
    }

public function show(Barang $barang)
{
    $role = Auth::user()->role;

    return match($role) {
        'admin'  => view('admin.barang.detail', compact('barang')),
        'kabeng' => view('kabeng.barang.detail', compact('barang')),
        default  => abort(403),
    };
}   
}
    