<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DynamicExport implements FromArray, WithHeadings
{
    protected $jenis;

    public function __construct($jenis)
    {
        $this->jenis = $jenis;
    }

    public function headings(): array
    {
        switch ($this->jenis) {

            case 'supplier':
                return ['ID', 'Nama Supplier', 'Alamat', 'Telepon', 'Dibuat Pada'];

            case 'barang_masuk':
                return ['ID', 'Nama Barang', 'Supplier', 'Jumlah', 'Tanggal Masuk'];

            case 'barang_keluar':
                return ['ID', 'Nama Barang', 'Jumlah', 'Keterangan', 'Tanggal Keluar'];

            case 'peminjaman':
                return ['ID', 'Nama Barang', 'Peminjam', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'];

                default: // barang
                return [
                    'Kode Barang',
                    'Nama Barang',
                    'Kategori',
                    'Jumlah',
                    'Kondisi',
                    'Lokasi',
                    'Jurusan',
                    'Keterangan',
                    'Spesifikasi',
                    'Sumber Dana',
                    'Tanggal Pembelian'
                ];
            
        }
    }

    public function array(): array
    {
        switch ($this->jenis) {

            case 'supplier':
                return Supplier::all()->map(function ($s) {
                    return [
                        $s->id,
                        $s->nama_supplier,
                        $s->alamat,
                        $s->telepon,
                        $s->created_at,
                    ];
                })->toArray();

            case 'barang_masuk':
                return BarangMasuk::with('barang','supplier')->get()->map(function ($b) {
                    return [
                        $b->id,
                        $b->barang->nama_barang ?? '-',
                        $b->supplier->nama_supplier ?? '-',
                        $b->jumlah,
                        $b->tanggal_masuk,
                    ];
                })->toArray();

            case 'barang_keluar':
                return BarangKeluar::with('barang')->get()->map(function ($b) {
                    return [
                        $b->id,
                        $b->barang->nama_barang ?? '-',
                        $b->jumlah,
                        $b->keterangan ?? '-',
                        $b->tanggal_keluar,
                    ];
                })->toArray();

            case 'peminjaman':
                return Peminjaman::with('barang','user')->get()->map(function ($p) {
                    return [
                        $p->id,
                        $p->barang->nama_barang ?? '-',
                        $p->user->name ?? '-',
                        $p->jumlah,
                        $p->tanggal_pinjam,
                        $p->tanggal_kembali,
                        $p->status,
                    ];
                })->toArray();

                default: // barang
                return Barang::whereNull('tanggal_penghapusan')->with('user')->get()->map(function ($b) {
                    return [
                        $b->kode_barang,
                        $b->nama_barang,
                        $b->kategori,
                        $b->jumlah,
                        $b->kondisi,
                        $b->lokasi,
                        $b->user->konsentrasi->nama_konsentrasi ?? '-', // jurusan
                        $b->keterangan ?? '-',
                        $b->spesifikasi ?? '-',
                        $b->sumber_dana ?? '-',
                        $b->tanggal_pembelian,
                    ];
                })->toArray();
        }
    }
}
