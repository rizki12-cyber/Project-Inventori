<?php

namespace App\Http\Controllers;

use App\Models\KonsentrasiKeahlian;
use App\Models\ProgramKeahlian;
use Illuminate\Http\Request;

class KonsentrasiKeahlianController extends Controller
{
    public function index()
    {
        $data = KonsentrasiKeahlian::with('programKeahlian')->get();
        return view('admin.konsentrasi.index', compact('data'));
    }

    public function create()
    {
        $programs = ProgramKeahlian::all();
        return view('admin.konsentrasi.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_keahlian_id' => 'required|exists:program_keahlians,id',
            'nama_konsentrasi' => 'required|string|max:255',
        ]);

        KonsentrasiKeahlian::create($request->all());
        return redirect()->route('admin.konsentrasi.index')->with('success', 'Konsentrasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $programs = ProgramKeahlian::all();
        return view('admin.konsentrasi.edit', compact('konsentrasi', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_keahlian_id' => 'required|exists:program_keahlians,id',
            'nama_konsentrasi' => 'required|string|max:255',
        ]);

        $konsentrasi = KonsentrasiKeahlian::findOrFail($id);
        $konsentrasi->update($request->all());

        return redirect()->route('admin.konsentrasi.index')->with('success', 'Konsentrasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        KonsentrasiKeahlian::findOrFail($id)->delete();
        return redirect()->route('admin.konsentrasi.index')->with('success', 'Konsentrasi berhasil dihapus!');
    }
}
