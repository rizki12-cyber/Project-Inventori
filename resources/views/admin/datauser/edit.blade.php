@extends('layouts.admin')
@section('title', 'Edit User')

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

/* Password toggle */
.input-group { position: relative; }
.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
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
        <i class="bi bi-pencil-square me-2"></i> Edit User
    </h2>

    <!-- CARD -->
    <div class="card-modern">

        <form action="{{ route('admin.datauser.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Nama -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- Password -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                        <span class="toggle-password" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="wakasek" {{ $user->role == 'wakasek' ? 'selected' : '' }}>Wakasek</option>
                        <option value="kabeng" {{ $user->role == 'kabeng' ? 'selected' : '' }}>Kabeng</option>
                    </select>
                </div>

                <!-- Jurusan -->
                <div class="col-md-6 mb-3" id="jurusanField" style="{{ $user->role == 'kabeng' ? '' : 'display:none;' }}">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($konsentrasiKeahlians as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ $user->jurusan == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_konsentrasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.datauser.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.querySelector('.toggle-password i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

document.getElementById('role').addEventListener('change', function() {
    const jurusanField = document.getElementById('jurusanField');
    jurusanField.style.display = this.value === 'kabeng' ? 'block' : 'none';
});
</script>

@endsection
