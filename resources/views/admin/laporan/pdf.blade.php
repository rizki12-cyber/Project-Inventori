<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #ddd; }
        h3 { text-align: center; margin-bottom: 0; }
        p { text-align: center; margin-top: 2px; font-size: 11px; }
    </style>
</head>
<body>
    <h3>LAPORAN INVENTORI BARANG SEKOLAH</h3>
    <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Tanggal Pembelian</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->jumlah }}</td>
                    <td>{{ $b->kondisi }}</td>
                    <td>{{ $b->lokasi }}</td>
                    <td>{{ $b->tanggal_pembelian }}</td>
                    <td>{{ $b->user->jurusan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
