@extends('layouts.admin')

@section('title', 'Tambah Supplier')

@section('content')
<style>
    :root {
        --primary-main: #4e73df;
        --primary-dark: #2C52ED;
        --secondary-bg: #F8F9FC;
        --text-dark: #37474F;
        --card-bg: #FFFFFF;
        --light-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        --success-main: #1cc88a;
        --danger-main: #e74a3b;
        --warning-main: #f6c23e;
    }

    body {
        background-color: var(--secondary-bg);
        font-family: 'Roboto', sans-serif;
        color: var(--text-dark);
        overflow-x: hidden;
    }

    @keyframes bounceInDown {
        0%, 60%, 75%, 90%, 100% { transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000); }
        0% { opacity: 0; transform: translate3d(0, -3000px, 0) scaleY(3); }
        60% { opacity: 1; transform: translate3d(0, 25px, 0) scaleY(0.9); }
        75% { transform: translate3d(0, -10px, 0) scaleY(0.95); }
        90% { transform: translate3d(0, 5px, 0) scaleY(0.98); }
        100% { transform: translate3d(0, 0, 0) scaleY(1); }
    }

    @keyframes fadeInSlideRight {
        0% { opacity: 0; transform: translateX(-50px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    @keyframes popIn {
        0% { opacity: 0; transform: scale(0.5); }
        80% { opacity: 1; transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    @keyframes sweepLine {
        0% { transform: translateX(-100%) skewX(-30deg); opacity: 0; }
        50% { transform: translateX(150%) skewX(-30deg); opacity: 1; }
        100% { transform: translateX(300%) skewX(-30deg); opacity: 0; }
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-main), var(--primary-dark));
        color: white;
        border-radius: 15px;
        padding: 2.5rem 3rem;
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
        margin-bottom: 3rem; /* beri jarak yang cukup */
        position: relative;
        overflow: hidden;
        animation: bounceInDown 1.5s both;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 20%; height: 100%;
        background: rgba(255, 255, 255, 0.3);
        animation: sweepLine 3s infinite ease-in-out;
        pointer-events: none;
        z-index: 0;
    }

    .page-header h2, .header-badge { position: relative; z-index: 1; }
    .page-header h2 { font-weight: 900; font-size: 2.2rem; }

    .header-badge {
        background: var(--card-bg);
        color: var(--primary-dark);
        font-weight: 700;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: popIn 0.8s 1s both;
    }

    /* FORM CARD */
    .form-card {
        background-color: var(--card-bg);
        border-radius: 15px;
        box-shadow: var(--light-shadow);
        padding: 2rem;
        opacity: 0;
        animation: fadeInSlideRight 1s 0.7s both;
        transition: all 0.3s ease;
        margin-top: 1rem; /* jarak aman dari header */
    }

    .form-control {
        border-radius: 10px;
        padding: 0.8rem 1rem;
        border: 1px solid #D1D3E2;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: var(--primary-main);
        box-shadow: 0 0 10px rgba(78,115,223,0.2);
    }

    .btn-submit {
        background: linear-gradient(180deg, var(--success-main), #17a673);
        color: white;
        border-radius: 10px;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        box-shadow: 0 4px 10px rgba(28, 200, 138, 0.3);
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background: linear-gradient(180deg, #17a673, #13885d);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(28, 200, 138, 0.5);
    }

    .btn-back {
        background: linear-gradient(180deg, #6c757d, #5a6268);
        color: white;
        border-radius: 10px;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }
    .btn-back:hover {
        background: linear-gradient(180deg, #5a6268, #4e555b);
        transform: translateY(-2px);
    }
</style>

<div class="container py-4">
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2><i class="bi bi-person-plus-fill me-2"></i> Tambah Supplier</h2>
            <p class="mb-0 text-light">Masukkan informasi lengkap supplier baru dengan mudah.</p>
        </div>
        <span class="header-badge shadow-sm fs-6">
            <i class="bi bi-people-fill me-2" style="color: var(--primary-main);"></i> Form Input
        </span>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.supplier.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror" value="{{ old('nama_supplier') }}" required>
                @error('nama_supplier')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" required>
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.supplier.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notifikasi sukses
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 1800,
            showConfirmButton: false
        });
        @endif
    });
</script>
@endsection
