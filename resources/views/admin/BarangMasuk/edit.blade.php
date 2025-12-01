@extends('layouts.admin')

@section('title', 'Edit Barang Masuk')

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
    border-radius: 10px;
    padding: 0.6rem 1.2rem;
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
    border-radius: 10px;
    padding: 0.6rem 1.2rem;
    transition: 0.3s;
}
.btn-save:hover {
    background: #1e40af;
    transform: translateY(-2px);
}

/* ========================================= */
/* RESPONSIVE BUTTONS – Sama seperti Tambah Barang Masuk */
/* ========================================= */
.button-wrapper {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}

/* Mobile: tombol full width bertumpuk */
@media (max-width: 576px) {
    .button-wrapper {
        flex-direction: column;
    }

    .button-wrapper .btn {
        width: 100%;
        text-align: center;
    }

    .page-title {
        font-size: 1.2rem;
    }
}
</style>

<div class="container py-4 data-container">

    <!-- HEADER -->
    <h2 class="page-title mb-4">
        <i class="bi bi-pencil-square me-2"></i> Edit Barang Masuk
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <form action="{{ route('admin.barangmasuk.update', $barangMasuk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Barang -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="id_barang" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                        <option value="{{ $b->id }}" 
                            {{ $barangMasuk->id_barang == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Supplier</label>
                    <select name="id_supplier" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $s)
                        <option value="{{ $s->id }}" 
                            {{ $barangMasuk->id_supplier == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_supplier }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control"
                        value="{{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('Y-m-d') }}" required>
                </div>

                <!-- Jumlah -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1"
                        value="{{ $barangMasuk->jumlah }}" required>
                </div>
            </div>

            <!-- Tombol dengan Wrapper Responsive -->
            <div class="button-wrapper mt-3">
                <a href="{{ route('admin.barangmasuk.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-save">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
