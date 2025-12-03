<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;
use App\Models\LogAktivitas;

class PengaturanController extends Controller
{
    // 📝 Fungsi log aktivitas
    private function catatLog($aksi)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'role'    => auth()->user()->role ?? '-',
            'aksi'    => $aksi,
        ]);
    }

    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        $pengaturan->nama_sekolah = $request->nama_sekolah;
        $pengaturan->footer_text = $request->footer_text;

        // Upload logo sekolah
        if ($request->hasFile('logo_sekolah')) {
            $file = $request->file('logo_sekolah');
            $filename = 'logo_sekolah_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/pengaturan', $filename);
            $pengaturan->logo_sekolah = 'uploads/pengaturan/' . $filename;
        }

        // Upload favicon
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move('uploads/pengaturan', $faviconName);
            $pengaturan->favicon = 'uploads/pengaturan/' . $faviconName;
        }

        $pengaturan->save();

        // ✨ Log aktivitas
        $this->catatLog("Mengubah pengaturan website (nama sekolah, logo, footer, favicon)");

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
