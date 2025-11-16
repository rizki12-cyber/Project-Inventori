@extends('layouts.kabeng')

@section('title', 'Edit Data Barang')

@section('content')

<style>
    .edit-container {
        animation: fadeSlideIn 0.8s forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .btn-save {
        background: #2563eb;
        color: #fff;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 25px;
        font-weight: 600;
    }

    .btn-save:hover {
        background: #1e3a8a;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #111827;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 25px;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    label {
        font-weight: 600;
        color: #1f2937;
    }
</style>

<div class="container py-4 edit-container">

    <div class="card p-4">
        <h3 class="fw-bold mb-4 text-primary">
            <i class="bi bi-pencil-square me-2"></i>Edit Barang
        </h3>

        <form action="{{ route('kabeng.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control"
                           value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control"
                           value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control"
                           value="{{ old('kategori', $barang->kategori) }}" required>
                </div>

                <div class="col-md-12">
                    <label>Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3">{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control"
                           value="{{ old('jumlah', $barang->jumlah) }}" required min="1">
                </div>

                <div class="col-md-6">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                           value="{{ old('lokasi', $barang->lokasi) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control"
                           value="{{ old('tanggal_pembelian', $barang->tanggal_pembelian) }}" required>
                </div>

                <div class="col-md-6">
                    <label>Sumber Dana</label>
                    <input type="text" name="sumber_dana" class="form-control"
                           value="{{ old('sumber_dana', $barang->sumber_dana) }}">
                </div>

                <div class="col-md-6">
                    <label>Tanggal Penghapusan (opsional)</label>
                    <input type="date" name="tanggal_penghapusan" class="form-control"
                           value="{{ old('tanggal_penghapusan', $barang->tanggal_penghapusan) }}">
                </div>

                <div class="col-md-12">
                    <label>Foto Barang (opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">

                    @if ($barang->foto)
                        <small class="text-muted d-block mt-1">
                            Foto sekarang: <strong>{{ $barang->foto }}</strong>
                        </small>
                        <img src="{{ asset('storage/foto_barang/' . $barang->foto) }}"
                             alt="Foto Barang" class="mt-2 rounded" style="width: 120px;">
                    @endif
                </div>

                <div class="col-md-12">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control"
                           value="{{ old('keterangan', $barang->keterangan) }}">
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('kabeng.barang.index') }}" class="btn btn-cancel me-2">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
