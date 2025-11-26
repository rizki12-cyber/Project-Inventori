@extends('layouts.admin')

@section('title', 'Edit Barang Keluar')

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
        <i class="bi bi-pencil-square me-2"></i> Edit Barang Keluar
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <form action="{{ route('admin.barangkeluar.update', $barangKeluar->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Nama Barang -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" 
                                {{ $barangKeluar->barang_id == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Keluar -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control"
                        value="{{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('Y-m-d') }}" required>
                </div>

                <!-- Jumlah -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1"
                        value="{{ $barangKeluar->jumlah }}" required>
                </div>

                <!-- Lokasi -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                        value="{{ $barangKeluar->lokasi }}" required>
                </div>

                <!-- Penerima -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Penerima</label>
                    <input type="text" name="penerima" class="form-control"
                        value="{{ $barangKeluar->penerima }}" required>
                </div>

                <!-- Keterangan -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ $barangKeluar->keterangan }}</textarea>
                </div>

            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.barangkeluar.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
