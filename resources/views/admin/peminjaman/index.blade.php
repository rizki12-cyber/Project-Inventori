@extends('layouts.admin')
@section('title', 'Data Peminjaman')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Peminjaman</h2>
        <div>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">+ Tambah</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $p->nama_peminjam }}</td>
                    <td>{{ $p->barang->nama_barang }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                    <td>{{ $p->kondisi ?? '-' }}</td>
                    <td><span class="badge bg-{{ $p->status == 'Dipinjam' ? 'warning' : 'success' }}">{{ $p->status }}</span></td>
                    <td>
                        <a href="{{ route('admin.peminjaman.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin mau hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $peminjamans->links() }}
</div>
@endsection
