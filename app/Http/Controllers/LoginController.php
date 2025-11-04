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
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user dan password sesuai
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Tentukan guard berdasarkan role user
        $guard = match ($user->role) {
            'admin' => 'admin',
            'petugas' => 'petugas',
            default => null
        };

        if (!$guard) {
            return back()->with('error', 'Role pengguna tidak valid.');
        }

        // Login menggunakan guard yang sesuai
        Auth::guard($guard)->login($user);

        // Regenerasi session ID untuk keamanan
        $request->session()->regenerate();

        // Arahkan berdasarkan role
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!'),
            'petugas' => redirect()->route('petugas.dashboard')->with('success', 'Selamat datang, Petugas!'),
            default => redirect('/login'),
        };
    }

    /**
     * Logout dari guard yang sedang aktif
     */
    public function logout(Request $request)
    {
        // Logout hanya dari guard yang sedang aktif
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }

        // Invalidate hanya session aktif (bukan flush semua)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
