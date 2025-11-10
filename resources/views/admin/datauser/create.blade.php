@extends('layouts.admin')
@section('title', 'Tambah User')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
    }

    .add-container {
        max-width: 650px;
        margin: 50px auto;
        background: #ffffff;
        padding: 40px 35px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        animation: fadeSlideIn 0.8s ease forwards;
    }

    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h3 {
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    h3::before {
        content: "➕";
        font-size: 1.4rem;
    }

    label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 14px;
        border: 1.5px solid #cbd5e1;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .btn {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #34d399, #059669);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #10b981, #047857);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #94a3b8;
        border: none;
    }

    .btn-secondary:hover {
        background: #64748b;
        transform: translateY(-2px);
    }

    .fade-slide {
        animation: fadeSlideIn 0.6s ease-in-out;
    }

    .text-muted {
        font-size: 0.85rem;
    }
</style>

<div class="add-container">
    <h3>Tambah Data User</h3>

    <form action="{{ route('admin.datauser.store') }}" method="POST" class="fade-slide">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama user..." required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email user..." required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="wakasek">Wakasek</option>
                <option value="kabeng">Kabeng</option>
            </select>
        </div>

        <div class="mb-3" id="jurusanField" style="display:none;">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select">
                <option value="">-- Pilih Jurusan --</option>
                <option value="TKR">TKR</option>
                <option value="TSM">TSM</option>
                <option value="PPLG">PPLG</option>
                <option value="TKJ">TKJ</option>
                <option value="AKL">AKL</option>
                <option value="BDP">BDP</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.datauser.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const jurusanField = document.getElementById('jurusanField');
        jurusanField.style.display = this.value === 'kabeng' ? 'block' : 'none';
    });
</script>
@endsection
