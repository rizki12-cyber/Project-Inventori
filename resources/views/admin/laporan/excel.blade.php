<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 18px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f2f2f2;
            font-weight: bold;
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        table td {
            border: 1px solid #999;
            padding: 7px;
            vertical-align: top;
        }

        /* Zebra strip */
        tbody tr:nth-child(odd) {
            background: #fafafa;
        }
    </style>
</head>
<body>

    <h3>Laporan {{ ucfirst($jenis) }}</h3>

    <table>

        <thead>
        <tr>

            @if($jenis == 'barang')
                <th>ID</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Tanggal Pembelian</th>
                <th>Jurusan</th>

            @elseif($jenis == 'supplier')
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>

            @elseif($jenis == 'barang_masuk')
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>

            @elseif($jenis == 'barang_keluar')
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Keluar</th>

            @elseif($jenis == 'peminjaman')
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            @endif

        </tr>
        </thead>


        <tbody>
        @foreach ($data as $item)
            <tr>

                @if($jenis == 'barang')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->kondisi }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->tanggal_pembelian }}</td>
                    <td>{{ $item->user->jurusan ?? '-' }}</td>

                @elseif($jenis == 'supplier')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama_supplier }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->telepon }}</td>
                    <td>{{ $item->email }}</td>

                @elseif($jenis == 'barang_masuk')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tanggal_masuk }}</td>

                @elseif($jenis == 'barang_keluar')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tanggal_keluar }}</td>

                @elseif($jenis == 'peminjaman')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                    <td>{{ $item->status }}</td>
                @endif

            </tr>
        @endforeach
        </tbody>

    </table>

</body>
</html>
