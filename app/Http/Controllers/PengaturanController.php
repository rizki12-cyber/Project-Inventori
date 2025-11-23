<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        $pengaturan->nama_sekolah = $request->nama_sekolah;

        if ($request->hasFile('logo_sekolah')) {
            $file = $request->file('logo_sekolah');
            $filename = 'logo_sekolah_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/pengaturan', $filename);
            $pengaturan->logo_sekolah = 'uploads/pengaturan/' . $filename;
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move('uploads/pengaturan', $faviconName);
            $pengaturan->favicon = 'uploads/pengaturan/' . $faviconName;
        }

        $pengaturan->save();

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
