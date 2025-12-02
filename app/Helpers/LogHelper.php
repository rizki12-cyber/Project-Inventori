<?php

use App\Models\LogAktivitas;

function logAktivitas($aksi)
{
    try {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'role' => auth()->user()->role ?? 'tidak diketahui',
            'aksi' => $aksi
        ]);
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}
