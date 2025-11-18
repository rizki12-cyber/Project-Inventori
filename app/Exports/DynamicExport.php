<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;

class DynamicExport implements FromCollection
{
    protected $jenis;

    public function __construct($jenis)
    {
        $this->jenis = $jenis;
    }

    public function collection()
    {
        switch ($this->jenis) {
            case 'supplier':
                return Supplier::select('id', 'nama', 'telepon', 'alamat', 'created_at')->get();

            case 'barang_masuk':
                return BarangMasuk::with('supplier', 'barang')
                    ->get()
                    ->map(function ($b) {
                        return [
                            'id' => $b->id,
                            'barang' => $b->barang->nama_barang,
                            'supplier' => $b->supplier->nama,
                            'jumlah' => $b->jumlah,
                            'tanggal' => $b->tanggal,
                        ];
                    });

            case 'barang_keluar':
                return BarangKeluar::with('barang')
                    ->get()
                    ->map(function ($b) {
                        return [
                            'id' => $b->id,
                            'barang' => $b->barang->nama_barang,
                            'jumlah' => $b->jumlah,
                            'tanggal' => $b->tanggal,
                        ];
                    });

            case 'peminjaman':
                return Peminjaman::with('barang', 'user')
                    ->get()
                    ->map(function ($p) {
                        return [
                            'id' => $p->id,
                            'barang' => $p->barang->nama_barang,
                            'peminjam' => $p->user->name,
                            'tgl_pinjam' => $p->tanggal_pinjam,
                            'tgl_kembali' => $p->tanggal_kembali,
                            'status' => $p->status,
                        ];
                    });

            default:
                return Barang::select('kode_barang','nama_barang','kategori','jumlah','kondisi','lokasi','tanggal_pembelian')->get();
        }
    }
}
