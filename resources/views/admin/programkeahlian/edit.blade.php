@extends('layouts.admin')

@section('title', 'Edit Program Keahlian')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
.form-control {
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
        <i class="bi bi-pencil-square me-2"></i> Edit Program Keahlian
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <form action="{{ route('admin.programkeahlian.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Program -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Program Keahlian</label>
                <input type="text" name="nama_program" 
                       value="{{ old('nama_program', $program->nama_program) }}" 
                       class="form-control @error('nama_program') is-invalid @enderror" 
                       placeholder="Masukkan nama program keahlian..." required>
                @error('nama_program')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.programkeahlian.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

<!-- SWEETALERT SUCCESS -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 1800,
    showConfirmButton: false
});
</script>
@endif

@endsection
