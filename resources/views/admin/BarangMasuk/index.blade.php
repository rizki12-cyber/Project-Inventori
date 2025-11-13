@extends('layouts.admin')

@section('title', 'Data Barang Masuk')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Data Barang Masuk</h3>
    <a href="{{ route('admin.barangmasuk.create') }}" class="btn btn-primary mb-3">+ Tambah Barang Masuk</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Supplier</th>
                <th>Tanggal Masuk</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuk as $bm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bm->barang->nama_barang ?? '-' }}</td>
                <td>{{ $bm->supplier->nama_supplier ?? '-' }}</td>
                <td>{{ $bm->tanggal_masuk }}</td>
                <td>{{ $bm->jumlah }}</td>
                <td>
                    <form action="{{ route('admin.barangmasuk.destroy', $bm->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
