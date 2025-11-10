@extends('layouts.wakasek')

@section('title', 'Tambah Barang')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0e7ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
    }

    /* Animasi */
    .fadeInUp {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card dengan efek glass */
    .card {
        border: none;
        border-radius: 20px;
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .card-header {
        border: none;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        text-align: center;
        font-weight: 600;
        letter-spacing: 0.3px;
        font-size: 1.3rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(37,99,235,0.25);
    }

    /* Label & Input */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .form-control, .form-select, textarea {
        border-radius: 12px;
        border: 1px solid #d1d5db;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.25s ease;
        background-color: #ffffffcc;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.25rem rgba(37,99,235,0.25);
        outline: none;
        background-color: #fff;
    }

    /* Tombol */
    .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.6rem 1.3rem;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(16,185,129,0.35);
    }

    .btn-secondary {
        background: #64748b;
        border: none;
        color: white;
    }
    .btn-secondary:hover {
        background: #475569;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(71,85,105,0.3);
    }

    /* Responsif */
    @media (max-width: 576px) {
        .btn {
            width: 100%;
        }
    }
</style>

<div class="container py-5 fadeInUp">
    <div class="card mx-auto" style="max-width: 740px;">
        <div class="card-header">
            <i class="bi bi-plus-circle me-2"></i>Tambah Barang Baru
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
                            <option value="Hilang" {{ old('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
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
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan atau deskripsi tambahan...">{{ old('keterangan') }}</textarea>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-end">
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('wakasek.barang.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
