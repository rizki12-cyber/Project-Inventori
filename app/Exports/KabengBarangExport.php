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

class KabengBarangExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    WithCustomStartCell, 
    WithEvents
{
    use RegistersEventListeners;

    protected $user_id;
    protected $bulan;
    protected $tahun;
    protected $kondisi;

    public function __construct($user_id, $bulan = null, $tahun = null, $kondisi = null)
    {
        $this->user_id = $user_id;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kondisi = $kondisi;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function collection()
    {
        return Barang::query()
            ->where('user_id', $this->user_id)
            ->when($this->bulan, fn ($q) => $q->whereMonth('tanggal_pembelian', $this->bulan))
            ->when($this->tahun, fn ($q) => $q->whereYear('tanggal_pembelian', $this->tahun))
            ->when($this->kondisi, fn ($q) => $q->where('kondisi', $this->kondisi))
            ->get()
            ->map(function ($b, $i) {
                return [
                    'No' => $i + 1,
                    'Kode Barang' => $b->kode_barang,
                    'Nama Barang' => $b->nama_barang,
                    'Kategori' => $b->kategori,
                    'Jumlah' => $b->jumlah,
                    'Kondisi' => $b->kondisi,
                    'Lokasi' => $b->lokasi,
                    'Tanggal Pembelian' => $b->tanggal_pembelian,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Jumlah',
            'Kondisi',
            'Lokasi',
            'Tanggal Pembelian',
        ];
    }

    // ======================= STYLING ===========================
    public function styles(Worksheet $sheet)
    {
        $kabeng = Auth::user()->name;

        // ==== TITLE: Nama Kabeng Dinamis ====
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA BARANG - ' . strtoupper($kabeng));
        $sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // ==== SEKOLAH ====
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'SMK NEGERI 1 TALAGA');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        // ==== TANGGAL ====
        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Tanggal Cetak: ' . date('d-m-Y H:i'));
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

        // ==== HEADER TABLE ====
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);
        $sheet->getStyle('A4:H4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:H4')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9D9D9');

        // Auto width
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    // ===================== AFTER SHEET ==========================
    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $lastRow = $sheet->getHighestRow();

        // Border lengkap
        $sheet->getStyle("A4:H{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Rata tengah isi tabel
        $sheet->getStyle("A5:H{$lastRow}")
            ->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
    }
}
