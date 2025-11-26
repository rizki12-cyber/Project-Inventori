@extends('layouts.wakasek')

@section('title', 'Detail Barang')

@section('content')
<div class="container py-5">

    <!-- Page Title -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="page-title"><i class="bi bi-eye me-2"></i>Detail Barang</h2>
        <a href="{{ route('wakasek.barang.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Detail -->
    <div class="card p-4" style="border-radius: 20px; box-shadow: 0 6px 16px rgba(0,0,0,0.08);">
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
                <table class="table table-borderless">
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
                    <tr>
                        <th>Pemilik</th>
                        <td>
                            {{ $barang->user->name ?? 'Tidak diketahui' }} 
                            ({{ ucfirst($barang->user->role ?? 'Unknown') }})
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</div>

<style>
    .page-title {
        font-weight: 700;
        font-size: 1.8rem;
        background: linear-gradient(90deg, #2563eb, #1e40af);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0;
    }
</style>
@endsection
