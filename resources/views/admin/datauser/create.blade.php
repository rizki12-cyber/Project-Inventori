@extends('layouts.admin')
@section('title', 'Tambah User')

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

/* Password toggle container */
.input-group {
    position: relative;
}
.input-group .toggle-password {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6b7280;
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
        <i class="bi bi-person-plus me-2"></i> Tambah User
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.datauser.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama user..." required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan email user..." required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="wakasek">Wakasek</option>
                    <option value="kabeng">Kabeng</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Jurusan (hanya kabeng) -->
            <div class="mb-3" id="jurusanField" style="display:none;">
                <label class="form-label fw-semibold">Jurusan</label>
                <select name="jurusan" class="form-select">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($konsentrasiKeahlians as $jurusan)
                        <option value="{{ $jurusan->id }}">{{ $jurusan->nama_konsentrasi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.datauser.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.querySelector('.toggle-password i');
        if(password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Show/hide jurusan based on role
    document.getElementById('role').addEventListener('change', function() {
        const jurusanField = document.getElementById('jurusanField');
        jurusanField.style.display = this.value === 'kabeng' ? 'block' : 'none';
    });
</script>

@endsection
