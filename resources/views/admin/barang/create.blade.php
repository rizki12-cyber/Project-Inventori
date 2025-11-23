@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
    }

    .form-container {
        animation: fadeSlideIn 0.7s ease forwards;
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
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        background: #ffffff;
        transition: 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
    }

    .page-title {
        font-weight: 700;
        font-size: 1.8rem;
        background: linear-gradient(90deg, #2563eb, #1e40af);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
    }

    .form-control, .form-select, textarea {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-success {
        background: linear-gradient(90deg, #16a34a, #22c55e);
        border: none;
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 600;
    }

    .alert {
        border-radius: 10px;
        font-size: 0.9rem;
    }
</style>

<div class="container py-5 form-container">
    <div class="d-flex align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-plus-circle-dotted me-2"></i>Tambah Barang Baru</h2>
    </div>

    <div class="card p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada beberapa error:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" 
                        name="kode_barang" 
                        class="form-control" 
                        placeholder="Contoh : K002" 
                        value="{{ old('kode_barang') }}" 
                        required>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="0" value="{{ old('jumlah') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ old('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Penghapusan</label>
                    <input type="date" name="tanggal_penghapusan" class="form-control" value="{{ old('tanggal_penghapusan') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sumber Anggaran</label>
                    <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Foto Barang</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <div class="col-12">
                    <label class="form-label">Spesifikasi</label>
                    <textarea name="spesifikasi" rows="3" class="form-control" placeholder="Masukkan spesifikasi barang...">{{ old('spesifikasi') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="form-control" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
