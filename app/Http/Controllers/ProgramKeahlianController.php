<?php

namespace App\Http\Controllers;

use App\Models\ProgramKeahlian;
use Illuminate\Http\Request;

class ProgramKeahlianController extends Controller
{
    public function index()
    {
        $programs = ProgramKeahlian::all();
        return view('admin.programkeahlian.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programkeahlian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
        ]);

        ProgramKeahlian::create($request->only('nama_program'));

        return redirect()->route('admin.programkeahlian.index')->with('success', 'Program Keahlian berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $program = ProgramKeahlian::findOrFail($id);
        return view('admin.programkeahlian.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
        ]);

        $program = ProgramKeahlian::findOrFail($id);
        $program->update($request->only('nama_program'));

        return redirect()->route('admin.programkeahlian.index')->with('success', 'Program Keahlian berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $program = ProgramKeahlian::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.programkeahlian.index')->with('success', 'Program Keahlian berhasil dihapus!');
    }
}
