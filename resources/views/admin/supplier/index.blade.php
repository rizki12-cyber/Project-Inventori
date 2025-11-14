@extends('layouts.admin')

@section('title', 'Data Supplier')

@section('content')
<style>
    /* 🎨 COLOR PALETTE & VARIABLES (Biru Tua) */
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
        --table-header-bg: #EBF2FF;
        --table-header-text: var(--primary-dark);
        --table-hover-bg: #F0F5FF;
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --light-bg: #f8f9fc;
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

    /* 🔹 PAGE HEADER */
    .page-header {
        background: linear-gradient(135deg, var(--primary-main), var(--primary-dark));
        color: white;
        border-radius: 15px;
        padding: 2.5rem 3rem;
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
        margin-bottom: 2.5rem;
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
        pointer-events: none; z-index: 0;
    }
    
    .page-header h2, .page-header p, .header-badge { position: relative; z-index: 1; }
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

    .card {
        border-radius: 15px;
        box-shadow: var(--light-shadow);
        border: none;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeInSlideRight 1s 0.5s both;
        transition: all 0.3s ease;
    }
    
    .card-header {
        background: linear-gradient(180deg, var(--primary-main), #3a5ccc);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        font-weight: 600;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s ease;
    }

    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .table {
        min-width: 600px;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background-color: transparent;
        color: #5a5c69;
        font-weight: 600;
        text-transform: none;
        font-size: 1rem;
        padding: 1rem;
        border-top: none;
        text-align: center;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #E9ECEF;
        text-align: center;
        white-space: nowrap;
        transition: all 0.3s ease;
    }
    
    .table-hover tbody tr:hover {
        transform: translateX(8px);
        background-color: rgba(78, 115, 223, 0.08);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .action-buttons {
        white-space: nowrap;
        display: flex;
        gap: 0.3rem;
        justify-content: center;
    }

    .btn-primary-custom, .btn-primary {
        background: linear-gradient(180deg, var(--primary-color), #3a5ccc);
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 500;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover, .btn-primary:hover {
        background: linear-gradient(180deg, #3a5ccc, #2a4bbb);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.5);
    }
    
    .btn-edit-custom { 
        background: linear-gradient(180deg, var(--warning-color), #dda20a); 
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-edit-custom:hover { background: linear-gradient(180deg, #dda20a, #cc9209); transform: translateY(-2px); }
    
    .btn-delete-custom { 
        background: linear-gradient(180deg, var(--danger-color), #be2617); 
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-delete-custom:hover { background: linear-gradient(180deg, #be2617, #aa1a0a); transform: translateY(-2px); }
    
    .action-buttons .btn { padding: 0.4rem 0.6rem; font-size: 0.9rem; }

    .search-form { max-width: 350px; width: 100%; }
    .search-form .form-control { border-radius: 8px 0 0 8px; border-color: #D1D3E2; padding-left: 1rem; }
    .search-form .btn-search { border-radius: 0 8px 8px 0; }

    .spinner { animation: spin 1s linear infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<div class="container py-4">
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="mb-1"><i class="bi bi-person-badge-fill me-2"></i> Data Supplier</h2>
            <p class="mb-0 text-light">Kelola dan lihat daftar lengkap supplier yang bekerjasama.</p>
        </div>
        <span class="header-badge shadow-sm fs-6">
            <i class="bi bi-people-fill me-2" style="color: var(--primary-main);"></i> Total Supplier:
            <strong>{{ $suppliers->total() }}</strong>
        </span>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4" style="animation: popIn 0.8s 1.2s both;">
        <form action="{{ route('admin.supplier.index') }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama supplier..." value="{{ request('search') }}">
                <button class="btn btn-primary-custom btn-search" type="submit"><i class="bi bi-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.supplier.index') }}" class="btn btn-danger ms-2" title="Reset Pencarian" style="border-radius: 8px;"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.supplier.create') }}" class="btn btn-primary-custom px-4 py-2"><i class="bi bi-person-plus-fill me-1"></i> Tambah Supplier Baru</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($suppliers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">No</th>
                            <th width="200">Nama Supplier</th>
                            <th width="300">Alamat</th>
                            <th width="150">Telepon</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $index => $supplier)
                        <tr style="animation-delay: {{ 1.5 + ($index * 0.1) }}s">
                            <td class="fw-bold text-muted">{{ ($suppliers->currentPage()-1) * $suppliers->perPage() + $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $supplier->nama_supplier }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->telepon }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-warning btn-edit-custom btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline form-hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-delete-custom btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 pb-3 d-flex justify-content-center">{{ $suppliers->links() }}</div>
            @else
            <div class="empty-state text-center p-5">
                <i class="bi bi-box-fill display-4 text-muted"></i>
                <h5 class="mt-3">Data Supplier Tidak Ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci pencarian atau tambahkan supplier baru.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert2 Hapus
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin hapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });

    // SweetAlert2 Notifikasi sukses
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
