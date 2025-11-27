@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Animation & Basics */
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.profile-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }

@keyframes fadeSlideIn { 
    to { opacity: 1; transform: translateY(0); }
}

/* Page Title */
.page-title {
    font-weight: 700;
    font-size: 1.8rem;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
}

/* Card */
.card-profile {
    border: none;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    padding: 2rem;
}

/* Avatar */
.avatar-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
}
.avatar-circle {
    width: 95px;
    height: 95px;
    background: #2563eb;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    color: white;
    font-size: 2.6rem;
}

/* Form input */
.form-label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #334155;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    padding: 0.65rem 0.9rem;
}
.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
}

/* Password toggle */
.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
}
.password-toggle:hover { color: #1e40af; }

/* Submit button */
.btn-submit {
    background: #2563eb;
    color: white;
    border-radius: 50px;
    padding: 0.65rem 1.4rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: 0.3s;
    border: none;
}
.btn-submit:hover {
    background: #1e40af;
    transform: translateY(-2px);
}

/* Footer */
.profile-footer {
    margin-top: 1.8rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
    color: #64748b;
    font-size: 0.9rem;
}
</style>

<div class="container py-5 profile-container">
    
    <h2 class="page-title"><i class="bi bi-person-fill-gear me-2"></i>Profil Administrator</h2>

    <div class="card-profile">

        <div class="avatar-wrapper">
            <div class="avatar-circle">
                <i class="bi bi-person-fill"></i>
            </div>
        </div>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1600
                });
            </script>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $admin->name) }}" required>

                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $admin->email) }}" required>

                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <label class="form-label">Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror">

                <button type="button" class="password-toggle" data-target="password">
                    <i class="bi bi-eye"></i>
                </button>

                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4 position-relative">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">

                <button type="button" class="password-toggle" data-target="password_confirmation">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-save2"></i> Perbarui Profil
            </button>
        </form>

        <div class="profile-footer mt-4">
            <div><i class="bi bi-clock-history me-2"></i>Terakhir diperbarui: {{ $admin->updated_at->format('d M Y, H:i') }}</div>
            <div><i class="bi bi-person-badge me-2"></i>Status: Administrator</div>
        </div>
    </div>
</div>

<script>
// Password show/hide
document.querySelectorAll('.password-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        if (target.type === 'password') {
            target.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            target.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script>

@endsection
