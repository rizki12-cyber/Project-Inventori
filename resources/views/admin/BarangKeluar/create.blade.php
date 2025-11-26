@extends('layouts.admin')

@section('title', 'Tambah Barang Keluar')

@section('content')

<style>
/* Fade animation */
.data-container { 
    animation: fadeSlideIn 0.7s ease forwards; 
    opacity: 0; 
    transform: translateY(20px); 
}
@keyframes fadeSlideIn { 
    to { opacity: 1; transform: translateY(0); } 
}

/* Page Title */
.page-title {
    font-weight: 700;
    font-size: 1.7rem;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Card */
.card-modern {
    border: none; 
    border-radius: 20px; 
    background: #fff; 
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    padding: 2rem;
}

/* Inputs */
.form-control, .form-select {
    border-radius: 10px;
    padding: 0.6rem 0.9rem;
}

/* Buttons */
.btn-back {
    background: #6b7280;
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.6rem 1.3rem;
    transition: 0.3s;
}
.btn-back:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.btn-save {
    background: #2563eb;
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.6rem 1.3rem;
    transition: 0.3s;
}
.btn-save:hover {
    background: #1e40af;
    transform: translateY(-2px);
}
</style>

<div class="container py-4 data-container">

    <!-- HEADER -->
    <h2 class="page-title mb-4">
        <i class="bi bi-box-arrow-up me-2"></i> Tambah Barang Keluar
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.barangkeluar.store') }}" method="POST">
            @csrf

            <!-- Barang -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Barang</label>
                <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }} (Stok: {{ $b->jumlah }})
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal Keluar -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" 
                    value="{{ old('tanggal_keluar') }}"
                    class="form-control @error('tanggal_keluar') is-invalid @enderror" required>
                @error('tanggal_keluar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah</label>
                <input type="number" name="jumlah" min="1"
                    value="{{ old('jumlah') }}"
                    class="form-control @error('jumlah') is-invalid @enderror" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lokasi -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi</label>
                <input type="text" name="lokasi"
                    value="{{ old('lokasi') }}"
                    placeholder="Contoh: Ruang Lab, Gudang A, dll"
                    class="form-control @error('lokasi') is-invalid @enderror">
                @error('lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Penerima -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Penerima</label>
                <input type="text" name="penerima"
                    value="{{ old('penerima') }}"
                    placeholder="Nama penerima barang"
                    class="form-control @error('penerima') is-invalid @enderror">
                @error('penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="form-control @error('keterangan') is-invalid @enderror"
                    placeholder="Opsional">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.barangkeluar.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
