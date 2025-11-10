@extends('layouts.wakasek')

@section('title', 'Tambah Barang')

@section('content')
<style>
    body {
        background: #f0f4ff;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .card-header {
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
        text-align: center;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .form-label {
        font-weight: 600;
        color: #1e293b;
    }

    .form-control, .form-select, textarea {
        border-radius: 12px;
        border: 1px solid #d1d5db;
        transition: all 0.25s ease-in-out;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59,130,246,0.2);
        outline: none;
    }

    .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.55rem 1.25rem;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16,185,129,0.3);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        border: none;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(75,85,99,0.3);
    }

    @media (max-width: 576px) {
        .btn {
            width: 100%;
        }
    }
</style>

<div class="container py-5">
    <div class="card mx-auto shadow-sm" style="max-width: 720px;">
        <div class="card-header">
            <h5 class="mb-0">Tambah Barang Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('wakasek.barang.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}" required>
                        @error('kode_barang')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" min="1" class="form-control" value="{{ old('jumlah') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-end">
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('wakasek.barang.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
