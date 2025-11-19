<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileKabengController extends Controller
{
    /**
     * Tampilkan halaman profil Kabeng.
     */
    public function index()
    {
        $kabeng = Auth::user(); // mengambil data user yang sedang login
        return view('kabeng.profile', compact('kabeng'));
    }

    /**
     * Update profil Kabeng.
     * Tanpa perubahan password.
     */
    public function update(Request $request)
    {
        $kabeng = Auth::user();

        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
