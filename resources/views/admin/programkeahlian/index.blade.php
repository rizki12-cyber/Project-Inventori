@extends('layouts.admin')

@section('title', 'Data Program Keahlian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-graduation-cap me-3"></i>
                                Data Program Keahlian
                            </h2>
                            <p class="text-white text-opacity-75 mb-0 mt-2">
                                Kelola program keahlian yang tersedia di sistem
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-light btn-lg rounded-pill shadow-sm">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notification -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <h6 class="mb-0 text-success">Berhasil!</h6>
                    <p class="mb-0 text-success">{{ session('success') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-white py-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>
                                Daftar Program Keahlian
                            </h5>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                Total: {{ count($programs) }} Program
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light bg-opacity-50">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase text-secondary font-weight-bold" style="width: 80px;">
                                        No
                                    </th>
                                    <th class="py-3 text-uppercase text-secondary font-weight-bold">
                                        Nama Program Keahlian
                                    </th>
                                    <th class="text-center py-3 text-uppercase text-secondary font-weight-bold" style="width: 200px;">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $i => $program)
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle me-3 p-2">
                                                    <i class="fas fa-bookmark fs-6"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-dark">{{ $program->nama_program }}</h6>
                                                    <small class="text-muted">Program Keahlian</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.programkeahlian.edit', $program->id) }}" 
                                                   class="btn btn-outline-warning btn-sm rounded-pill px-3 py-2 d-flex align-items-center">
                                                    <i class="fas fa-edit me-2"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.programkeahlian.destroy', $program->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 d-flex align-items-center"
                                                            onclick="return confirm('Yakin ingin menghapus program {{ $program->nama_program }}?')">
                                                        <i class="fas fa-trash me-2"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="icon-shape bg-light bg-opacity-25 text-primary rounded-circle p-4 mb-3 d-inline-block">
                                                    <i class="fas fa-inbox fs-1"></i>
                                                </div>
                                                <h5 class="text-muted mb-3">Belum ada data program keahlian</h5>
                                                <p class="text-muted mb-4">Mulai dengan menambahkan program keahlian pertama Anda</p>
                                                <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                                    <i class="fas fa-plus me-2"></i>
                                                    Tambah Program Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Card Footer -->
                @if(count($programs) > 0)
                <div class="card-footer bg-white py-3 border-top">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="mb-0 text-muted">
                                Menampilkan <strong>{{ count($programs) }}</strong> program keahlian
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-blue: #3498db;
    --light-blue: #e8f4fc;
    --soft-blue: #f8fbff;
    --medium-blue: #d1e7f5;
    --dark-blue: #2980b9;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --gradient-primary: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    --gradient-light: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
}

body {
    background: var(--gradient-light);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
}

.bg-gradient-primary {
    background: var(--gradient-primary) !important;
}

.btn-light {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background: rgba(255, 255, 255, 1);
    transform: translateY(-2px);
}

.alert-success {
    background: rgba(46, 204, 113, 0.1);
    border: 1px solid rgba(46, 204, 113, 0.2);
    color: #27ae60;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    border-color: #f1f8ff;
}

.icon-shape {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-outline-warning {
    color: #f39c12;
    border-color: #f39c12;
    transition: all 0.3s ease;
}

.btn-outline-warning:hover {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
    transform: translateY(-1px);
}

.btn-outline-danger {
    color: #e74c3c;
    border-color: #e74c3c;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
    transform: translateY(-1px);
}

.empty-state {
    padding: 3rem 1rem;
}

.badge.bg-primary.bg-opacity-10 {
    font-size: 0.875rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(52, 152, 219, 0.04);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.rounded-3 {
    border-radius: 1rem !important;
}

.rounded-pill {
    border-radius: 50rem !important;
}
</style>

<!-- Include Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection