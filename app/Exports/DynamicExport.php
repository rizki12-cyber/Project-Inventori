<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DynamicExport implements 
    FromArray, 
    WithHeadings, 
    WithStyles, 
    WithCustomStartCell,
    WithEvents
{
    use RegistersEventListeners;

    protected $jenis;

    public function __construct($jenis)
    {
        $this->jenis = $jenis;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    // ================= HEADINGS ===================
    public function headings(): array
    {
        switch ($this->jenis) {

            case 'supplier':
                return ['No', 'Nama Supplier', 'Alamat', 'Telepon', 'Dibuat Pada'];

            case 'barang_masuk':
                return ['No', 'Nama Barang', 'Supplier', 'Jumlah', 'Tanggal Masuk'];

            case 'barang_keluar':
                return ['No', 'Nama Barang', 'Jumlah', 'Keterangan', 'Tanggal Keluar'];

            case 'peminjaman':
                return ['No', 'Nama Barang', 'Peminjam', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'];

            case 'barang_dihapus':
                return [
                    'No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Kondisi', 'Lokasi',
                    'Jurusan', 'Keterangan', 'Spesifikasi', 'Sumber Dana', 'Tanggal Pembelian', 'Tanggal Penghapusan'
                ];

            default:
                return [
                    'No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Jumlah', 'Kondisi',
                    'Lokasi', 'Jurusan', 'Keterangan', 'Spesifikasi', 'Sumber Dana', 'Tanggal Pembelian'
                ];
        }
    }

    // ================= DATA ARRAY ==================
    public function array(): array
    {
        switch ($this->jenis) {

            case 'supplier':
                return Supplier::all()->values()->map(fn ($s, $i) => [
                    $i + 1,
                    $s->nama_supplier,
                    $s->alamat,
                    $s->telepon,
                    $s->created_at
                ])->toArray();

            case 'barang_masuk':
                return BarangMasuk::with('barang','supplier')->get()->values()->map(fn ($b, $i) => [
                    $i + 1,
                    $b->barang->nama_barang ?? '-',
                    $b->supplier->nama_supplier ?? '-',
                    $b->jumlah,
                    $b->tanggal_masuk
                ])->toArray();

            case 'barang_keluar':
                return BarangKeluar::with('barang')->get()->values()->map(fn ($b, $i) => [
                    $i + 1,
                    $b->barang->nama_barang ?? '-',
                    $b->jumlah,
                    $b->keterangan ?? '-',
                    $b->tanggal_keluar
                ])->toArray();

            case 'peminjaman':
                return Peminjaman::with('barang','user')->get()->values()->map(fn ($p, $i) => [
                    $i + 1,
                    $p->barang->nama_barang ?? '-',
                    $p->nama_peminjam ?? ($p->user->name ?? '-'),
                    $p->jumlah,
                    $p->tanggal_pinjam,
                    $p->tanggal_kembali,
                    $p->status
                ])->toArray();

            case 'barang_dihapus':
                return Barang::whereNotNull('tanggal_penghapusan')->with('user')->get()->values()->map(fn ($b, $i) => [
                    $i + 1,
                    $b->kode_barang,
                    $b->nama_barang,
                    $b->kategori,
                    $b->jumlah,
                    $b->kondisi,
                    $b->lokasi,
                    $b->user->konsentrasi->nama_konsentrasi ?? '-',
                    $b->keterangan ?? '-',
                    $b->spesifikasi ?? '-',
                    $b->sumber_dana ?? '-',
                    $b->tanggal_pembelian,
                    $b->tanggal_penghapusan
                ])->toArray();

            default:
                return Barang::whereNull('tanggal_penghapusan')->with('user')->get()->values()->map(fn ($b, $i) => [
                    $i + 1,
                    $b->kode_barang,
                    $b->nama_barang,
                    $b->kategori,
                    $b->jumlah,
                    $b->kondisi,
                    $b->lokasi,
                    $b->user->konsentrasi->nama_konsentrasi ?? '-',
                    $b->keterangan ?? '-',
                    $b->spesifikasi ?? '-',
                    $b->sumber_dana ?? '-',
                    $b->tanggal_pembelian
                ])->toArray();
        }
    }

    // ================= STYLING ======================
    public function styles(Worksheet $sheet)
    {
        $user = Auth::user()->name;

        $colCount = count($this->headings());
        $lastCol = chr(64 + $colCount);

        // ===== TITLE =====
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue("A1", "LAPORAN DATA " . strtoupper($this->jenis) . " - " . strtoupper($user));
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle("A1")->getAlignment()->setHorizontal('center');

        // SEKOLAH
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue("A2", "SMK NEGERI 1 TALAGA");
        $sheet->getStyle("A2")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("A2")->getAlignment()->setHorizontal('center');

        // TANGGAL
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->setCellValue("A3", "Tanggal Cetak: " . date('d-m-Y H:i'));
        $sheet->getStyle("A3")->getAlignment()->setHorizontal('center');

        // HEADER STYLE
        $sheet->getStyle("A4:{$lastCol}4")->getFont()->setBold(true);
        $sheet->getStyle("A4:{$lastCol}4")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB("D9D9D9");
        $sheet->getStyle("A4:{$lastCol}4")->getAlignment()->setHorizontal('center');

        // AUTO WIDTH
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    // =============== AFTER SHEET ====================
    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();

        // BORDER FULL
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // RATA TENGAH ISI
        $sheet->getStyle("A5:{$lastCol}{$lastRow}")
            ->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
    }
}
