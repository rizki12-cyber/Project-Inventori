<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;

class AdminController extends Controller
{
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // ==============================
        // LOG AKTIVITAS
        // ==============================
        LogAktivitas::create([
            'user_id'    => $admin->id,
            'role'       => $admin->role ?? 'admin',
            'aksi'       => 'Update Profil Admin',
            'target'     => $admin->name,
            'status'     => 'berhasil',
            'ip_device'  => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // ==============================

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
