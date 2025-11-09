<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class BarangExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Barang::with('user')
            ->when($this->request->bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $this->request->bulan))
            ->when($this->request->tahun, fn($q) => $q->whereYear('tanggal_pembelian', $this->request->tahun))
            ->when($this->request->jurusan, fn($q) => $q->whereHas('user', fn($u) => $u->where('jurusan', $this->request->jurusan)))
            ->when($this->request->kondisi, fn($q) => $q->where('kondisi', $this->request->kondisi))
            ->get()
            ->map(function ($b) {
                return [
                    'Kode Barang' => $b->kode_barang,
                    'Nama Barang' => $b->nama_barang,
                    'Kategori' => $b->kategori,
                    'Jumlah' => $b->jumlah,
                    'Kondisi' => $b->kondisi,
                    'Lokasi' => $b->lokasi,
                    'Tanggal Pembelian' => $b->tanggal_pembelian,
                    'Jurusan' => $b->user->jurusan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Kondisi', 'Lokasi', 'Tanggal Pembelian', 'Jurusan'];
    }
}
