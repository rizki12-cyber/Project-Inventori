@extends('layouts.kabeng')

@section('title', 'Detail Barang')

@section('content')
<div class="container py-5">

    <div class="card shadow-lg p-4" style="border-radius: 20px;">
        <h3 class="mb-4"><i class="bi bi-eye me-2"></i>Detail Barang</h3>

        <div class="row">

            <div class="col-md-4 text-center">
                @if($barang->foto)
                    <img src="{{ asset('storage/foto_barang/' . $barang->foto) }}"
                         class="img-fluid rounded mb-3"
                         style="max-height:250px;object-fit:cover;">
                @else
                    <div class="text-muted">Tidak ada foto</div>
                @endif
            </div>

            <div class="col-md-8">
                <table class="table">
                    <tr><th>Kode Barang</th><td>{{ $barang->kode_barang }}</td></tr>
                    <tr><th>Nama Barang</th><td>{{ $barang->nama_barang }}</td></tr>
                    <tr><th>Kategori</th><td>{{ $barang->kategori }}</td></tr>
                    <tr><th>Jumlah</th><td>{{ $barang->jumlah }}</td></tr>
                    <tr><th>Kondisi</th><td>{{ $barang->kondisi }}</td></tr>
                    <tr><th>Tanggal Pembelian</th><td>{{ $barang->tanggal_pembelian }}</td></tr>
                    <tr><th>Tanggal Penghapusan</th><td>{{ $barang->tanggal_penghapusan ?? '-' }}</td></tr>
                    <tr><th>Sumber Anggaran</th><td>{{ $barang->sumber_dana ?? '-' }}</td></tr>
                    <tr><th>Spesifikasi</th><td>{{ $barang->spesifikasi ?? '-' }}</td></tr>
                    <tr><th>Keterangan</th><td>{{ $barang->keterangan ?? '-' }}</td></tr>
                    <tr><th>Pemilik</th><td>{{ $barang->user->role === 'wakasek' ? $barang->user->name . ' (Wakasek)' : 'Anda sendiri' }}</td></tr>
                </table>
            </div>

        </div>

        <a href="{{ route('kabeng.barang.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

    </div>

</div>
@endsection
