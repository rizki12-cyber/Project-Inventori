@extends('layouts.wakasek')

@section('title', 'Edit Barang (Wakasek)')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white fw-bold">
            Edit Data Barang
        </div>
        <div class="card-body">
            <form action="{{ route('wakasek.barang.update', $barang->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $barang->kategori) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $barang->jumlah) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="Layak" {{ $barang->kondisi == 'Layak' ? 'selected' : '' }}>Layak</option>
                            <option value="Rusak" {{ $barang->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $barang->lokasi) }}" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian', $barang->tanggal_pembelian) }}" required>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('wakasek.barang.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
