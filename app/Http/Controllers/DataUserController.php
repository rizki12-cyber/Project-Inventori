<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.datauser.index', compact('users'));
    }

    public function create()
    {
        return view('admin.datauser.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:wakasek,kabeng',
            'jurusan'  => 'nullable|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'jurusan'  => $request->role === 'kabeng' ? $request->jurusan : null,
        ]);

        return redirect()->route('admin.datauser.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $datauser)
    {
        return view('admin.datauser.edit', ['user' => $datauser]);
    }

    public function update(Request $request, User $datauser)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $datauser->id,
            'role'     => 'required|in:wakasek,kabeng',
            'jurusan'  => 'nullable|string',
        ]);

        $data = $request->only(['name', 'email', 'role', 'jurusan']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $datauser->update($data);

        return redirect()->route('admin.datauser.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $datauser)
    {
        $datauser->delete();
        return redirect()->route('admin.datauser.index')->with('success', 'User berhasil dihapus!');
    }
}
