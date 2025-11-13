@extends('layouts.admin')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Tambah Barang Keluar</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.barangkeluar.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select name="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_barang }} (Stok: {{ $b->jumlah }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Ruang Lab, Gudang A, dll">
        </div>

        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" name="penerima" class="form-control" placeholder="Nama penerima barang">
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.barangkeluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
