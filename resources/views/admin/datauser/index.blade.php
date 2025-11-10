@extends('layouts.admin')
@section('title', 'Data User')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
    }

    /* Container animation */
    .data-container {
        animation: fadeUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card style */
    .card {
        border: none;
        border-radius: 18px;
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        color: white;
        font-weight: 600;
        padding: 0.85rem 1.25rem; /* dikurang biar lebih rapat */
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #1e3a8a;
    }

    .card-header h4 {
        margin: 0;
        letter-spacing: 0.3px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        border: none;
        border-radius: 10px;
        padding: 8px 14px; /* lebih kecil */
        color: #fff;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .btn-primary:hover {
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
    }

    .alert-success {
        border: none;
        border-radius: 10px;
        background: #d1fae5;
        color: #065f46;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
    }

    table {
        margin-top: 8px;
        border-collapse: separate;
        border-spacing: 0 8px;
        width: 100%;
    }

    thead th {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 600;
        border: none;
        padding: 10px;
        text-transform: uppercase;
        font-size: 0.82rem;
    }

    tbody tr {
        background: #ffffff;
        border-radius: 12px;
        transition: 0.25s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    tbody tr:hover {
        transform: scale(1.01);
        background: #f9fafb;
        box-shadow: 0 3px 12px rgba(0,0,0,0.07);
    }

    td {
        padding: 12px;
        vertical-align: middle;
        font-size: 0.92rem;
    }

    .badge {
        font-size: 0.78rem;
        border-radius: 10px;
        padding: 5px 10px;
        font-weight: 500;
    }

    .badge-role {
        background: linear-gradient(135deg, #bfdbfe, #93c5fd);
        color: #1e3a8a;
    }

    .btn-action {
        border-radius: 8px;
        padding: 6px 9px;
        transition: all 0.3s;
        border: none;
    }

    .btn-warning {
        background: #facc15;
        color: #1e293b;
    }

    .btn-warning:hover {
        background: #fbbf24;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        color: #94a3b8;
        padding: 30px 0;
    }

    .empty-state i {
        font-size: 1.8rem;
        color: #94a3b8;
    }
</style>

<div class="container mt-4 data-container"><!-- jarak dikurang jadi mt-4 -->
    <div class="card">
        <div class="card-header">
            <h4>👥 Data User</h4>
            <a href="{{ route('admin.datauser.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-person-plus-fill"></i> Tambah
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mt-2">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive mt-2">
                <table class="table align-middle text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold text-start ps-4">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-role">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->jurusan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.datauser.edit', $user->id) }}" 
                                           class="btn btn-sm btn-warning btn-action me-2" 
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.datauser.destroy', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-action" title="Hapus">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-emoji-frown"></i>
                                        <p class="mt-2">Belum ada user yang terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
