<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // ✅ Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // ✅ Cek user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.');
        }

        // ✅ Login dengan guard default (web)
        Auth::login($user);
        $request->session()->regenerate();

        // ✅ Arahkan sesuai role
        return match ($user->role) {
            'admin'   => redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!'),
            'wakasek' => redirect()->route('wakasek.dashboard')->with('success', 'Selamat datang, Wakasek!'),
            'kabeng'  => redirect()->route('kabeng.dashboard')->with('success', 'Selamat datang, Kabeng!'),
            default   => redirect('/login')->with('error', 'Role tidak dikenali.'),
        };
    }

    /**
     * Logout dari sistem
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
