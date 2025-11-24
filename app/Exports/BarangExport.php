<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BarangExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithEvents
{
    use RegistersEventListeners;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function collection()
    {
        return Barang::with('user')
            ->whereHas('user', fn($u) => $u->where('role', 'wakasek')) // ⬅ hanya barang milik wakasek
            ->when($this->request->bulan, fn($q) => $q->whereMonth('tanggal_pembelian', $this->request->bulan))
            ->when($this->request->tahun, fn($q) => $q->whereYear('tanggal_pembelian', $this->request->tahun))
            ->when($this->request->kondisi, fn($q) => $q->where('kondisi', $this->request->kondisi))
            ->get()
            ->map(function ($b) {
                return [
                    $b->kode_barang,
                    $b->nama_barang,
                    $b->kategori,
                    $b->jumlah,
                    $b->kondisi,
                    $b->lokasi,
                    $b->tanggal_pembelian,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah',
            'Kondisi', 'Lokasi', 'Tanggal Pembelian'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ==== TITLE ====
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'LAPORAN DATA BARANG WAKASEK');

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
        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A4:G4')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setRGB('D9D9D9');

        // AUTO SIZE
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        $lastRow = $sheet->getHighestRow();

        // Border hanya sampai kolom G
        $range = "A4:G{$lastRow}";

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
