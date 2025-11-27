<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KabengBarangExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithEvents
{
    use RegistersEventListeners;

    protected $request;
    protected $user;

    public function __construct($request)
    {
        $this->request = $request;
        $this->user = Auth::user();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function collection()
    {
        $jenis = $this->request->jenis;

        if ($jenis == 'barang') {
            $query = Barang::where('user_id', $this->user->id)
                ->whereNull('tanggal_penghapusan');
        } elseif ($jenis == 'barang_dihapus') {
            $query = Barang::where('user_id', $this->user->id)
                ->whereNotNull('tanggal_penghapusan');
        } else {
            return collect(); // default kosong
        }

        $data = $query
            ->when($this->request->bulan, fn($q) => $q->whereMonth(
                $jenis == 'barang' ? 'tanggal_pembelian' : 'tanggal_penghapusan',
                $this->request->bulan
            ))
            ->when($this->request->tahun, fn($q) => $q->whereYear(
                $jenis == 'barang' ? 'tanggal_pembelian' : 'tanggal_penghapusan',
                $this->request->tahun
            ))
            ->when($this->request->kondisi, fn($q) => $q->where('kondisi', $this->request->kondisi))
            ->get();

        return $data->map(function ($b) use ($jenis) {
            return [
                $b->kode_barang,
                $b->nama_barang,
                $b->kategori,
                $b->jumlah,
                $b->kondisi ?? '-',
                $b->lokasi,
                $jenis == 'barang' ? $b->tanggal_pembelian : $b->tanggal_penghapusan,
            ];
        });
    }

    public function headings(): array
    {
        if ($this->request->jenis == 'barang') {
            return [
                'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah',
                'Kondisi', 'Lokasi', 'Tanggal Pembelian'
            ];
        }

        return [
            'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah',
            'Kondisi', 'Lokasi', 'Tanggal Penghapusan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $judul = $this->request->jenis == 'barang'
            ? 'LAPORAN BARANG AKTIF KABENG'
            : 'LAPORAN BARANG DIHAPUS KABENG';

        // ==== TITLE ====
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', $judul);
        $sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // ==== SEKOLAH ====
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'SMK NEGERI 1 TALAGA');
        $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        // ==== TANGGAL EXPORT ====
        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue('A3', 'Tanggal Cetak: ' . date('d-m-Y H:i'));
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

        // ==== HEADER ====
        $sheet->getStyle('A5:G5')->getFont()->setBold(true);
        $sheet->getStyle('A5:G5')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setRGB('D9D9D9');
        $sheet->getStyle('A5:G5')->getAlignment()->setHorizontal('center');

        // ==== AUTO WIDTH ====
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }

    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $lastRow = $sheet->getHighestRow();
        $range = "A5:G{$lastRow}";

        // ==== BORDER ====
        $sheet->getStyle($range)->getBorders()
            ->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // ==== CENTER ALL DATA ====
        $sheet->getStyle($range)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($range)->getAlignment()->setVertical('center');
    }
}
