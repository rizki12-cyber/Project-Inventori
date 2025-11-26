@extends('layouts.admin')

@section('title', 'Edit Konsentrasi Keahlian')

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
        <i class="bi bi-pencil-square me-2"></i> Edit Konsentrasi Keahlian
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <!-- ERROR Validation -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.konsentrasi.update', $konsentrasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Program Keahlian -->
            <div class="mb-3">
                <label for="program_keahlian_id" class="form-label fw-semibold">Program Keahlian</label>
                <select name="program_keahlian_id" 
                        id="program_keahlian_id" 
                        class="form-select @error('program_keahlian_id') is-invalid @enderror" 
                        required>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ old('program_keahlian_id', $konsentrasi->program_keahlian_id) == $program->id ? 'selected' : '' }}>
                            {{ $program->nama_program }}
                        </option>
                    @endforeach
                </select>
                @error('program_keahlian_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nama Konsentrasi -->
            <div class="mb-3">
                <label for="nama_konsentrasi" class="form-label fw-semibold">Nama Konsentrasi Keahlian</label>
                <input type="text"
                       id="nama_konsentrasi"
                       name="nama_konsentrasi"
                       class="form-control @error('nama_konsentrasi') is-invalid @enderror"
                       value="{{ old('nama_konsentrasi', $konsentrasi->nama_konsentrasi) }}"
                       placeholder="Masukkan nama konsentrasi keahlian..."
                       required>
                @error('nama_konsentrasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.konsentrasi.index') }}" class="btn-back">
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
