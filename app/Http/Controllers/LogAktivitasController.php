<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest();

        // FILTER: Role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // FILTER: Keyword (pencarian nama & aksi)
        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('aksi', 'like', "%{$request->keyword}%")
                  ->orWhereHas('user', function ($u) use ($request) {
                      $u->where('name', 'like', "%{$request->keyword}%");
                  });
            });
        }

        // FILTER: tanggal mulai dan akhir
        if ($request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $logs = $query->paginate(20)->appends($request->all());

        return view('admin.log_aktivitas', compact('logs'));
    }
}
