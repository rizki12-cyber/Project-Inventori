<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Laporan</title>
</head>
<body>

    <h3 style="text-align:center; margin-bottom: 20px;">
        Laporan {{ ucfirst($jenis) }}
    </h3>

    <table border="1" cellspacing="0" cellpadding="6" style="width:100%; border-collapse: collapse;">

        {{-- ===========================
            HEADINGS
        ============================ --}}
        <thead>
        <tr style="background:#eee; font-weight:bold;">

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

        {{-- ===========================
            BODY TABLE
        ============================ --}}
        <tbody>
        @foreach ($data as $item)
            <tr>

                {{-- BARANG --}}
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

                {{-- SUPPLIER --}}
                @elseif($jenis == 'supplier')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama_supplier }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->telepon }}</td>
                    <td>{{ $item->email }}</td>

                {{-- BARANG MASUK --}}
                @elseif($jenis == 'barang_masuk')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tanggal_masuk }}</td>

                {{-- BARANG KELUAR --}}
                @elseif($jenis == 'barang_keluar')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tanggal_keluar }}</td>

                {{-- PEMINJAMAN --}}
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
