@extends('layouts.admin')

@section('title', 'Data Barang Keluar')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">📦 Data Barang Keluar</h3>

    <a href="{{ route('admin.barangkeluar.create') }}" class="btn btn-primary mb-3">
        + Tambah Barang Keluar
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Keluar</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Penerima</th>
                <th>Keterangan</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangKeluar as $i => $bk)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $bk->barang->nama_barang ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d-m-Y') }}</td>
                    <td>{{ $bk->jumlah }}</td>
                    <td>{{ $bk->lokasi ?? '-' }}</td>
                    <td>{{ $bk->penerima ?? '-' }}</td>
                    <td>{{ $bk->keterangan ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.barangkeluar.destroy', $bk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data barang keluar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
