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

        // ==== LIST LOKASI (ADMIN + KABENG + WAKASEK) ====
        $listLokasi = Barang::select('lokasi')
            ->whereNotNull('lokasi')
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)  // barang wakasek
                  ->orWhereHas('user', function($qq) {
                      $qq->whereIn('role', ['admin', 'kabeng']);  // barang admin & kabeng
                  });
            })
            ->groupBy('lokasi')
            ->pluck('lokasi');

        // ==== QUERY UTAMA (ADMIN + KABENG + WAKASEK) ====
        $barangQuery = Barang::where(function($q) use ($user) {

            // Barang milik wakasek sendiri
            $q->where('user_id', $user->id)

              // Barang admin
              ->orWhereHas('user', function($qq) {
                  $qq->where('role', 'admin');
              })

              // Barang kabeng
              ->orWhereHas('user', function($qq) {
                  $qq->where('role', 'kabeng');
              });
        });

        // ==== FILTER LOKASI ====
        if (request()->filled('lokasi')) {
            $barangQuery->where('lokasi', request('lokasi'));
        }

        $barang = $barangQuery->latest()->get();

        return view('wakasek.barang.index', compact('barang', 'listLokasi'));
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

        if ($user->role === 'kabeng') {
            $validated['jurusan'] = $user->programkeahlian?->nama_program;
        }

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

        if ($user->role === 'kabeng' && $barang->user_id != $user->id) {
            abort(403, 'Anda tidak diperbolehkan menghapus barang milik orang lain.');
        }

        if ($user->role === 'wakasek' && $barang->user_id != $user->id) {
            abort(403, 'Wakasek tidak diperbolehkan menghapus barang milik kabeng atau admin.');
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
        