<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WakasekProfileController extends Controller
{
    /**
     * Tampilkan halaman profil wakasek
     */
    public function index()
    {
        $wakasek = Auth::user();

        // kalau user belum login
        if (!$wakasek) {
            return redirect()->route('login')->with('error', 'Login dulu ya.');
        }

        return view('wakasek.profile', compact('wakasek'));
    }

    /**
     * Update profil wakasek
     */
    public function update(Request $request)
    {
        $wakasek = Auth::user();

        if (!$wakasek) {
            return redirect()->route('login')->with('error', 'Login dulu ya.');
        }

        // Validasi
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'nip'      => 'required|string|max:50',
            'jabatan'  => 'required|string|max:100',
            'email'    => 'required|email|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update avatar jika ada
        if ($request->hasFile('avatar')) {

            // Hapus foto lama jika ada
            if ($wakasek->avatar && Storage::disk('public')->exists($wakasek->avatar)) {
                Storage::disk('public')->delete($wakasek->avatar);
            }

            // Simpan foto baru
            $validated['avatar'] = $request->file('avatar')->store('wakasek', 'public');
        }

        // Update data user
        $wakasek->update($validated);

        return back()->with('success', 'Profil berhasil di-update 🔥');
    }
}
