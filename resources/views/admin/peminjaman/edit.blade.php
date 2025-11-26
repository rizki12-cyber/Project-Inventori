@extends('layouts.admin')
@section('title', 'Edit Peminjaman')

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
        <i class="bi bi-pencil-square me-2"></i> Edit Peminjaman
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Nama Peminjam -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam"
                        value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}"
                        class="form-control @error('nama_peminjam') is-invalid @enderror" required>
                    @error('nama_peminjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Barang -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" 
                                {{ $barang->id == $peminjaman->barang_id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" min="1"
                        value="{{ old('jumlah', $peminjaman->jumlah) }}"
                        class="form-control @error('jumlah') is-invalid @enderror" required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" {{ old('kondisi', $peminjaman->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ old('kondisi', $peminjaman->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Pinjam -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam"
                        value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
                        class="form-control @error('tanggal_pinjam') is-invalid @enderror" required>
                    @error('tanggal_pinjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Kembali -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali"
                        value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
                        class="form-control @error('tanggal_kembali') is-invalid @enderror">
                    @error('tanggal_kembali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Dipinjam" {{ $peminjaman->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-back">
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
