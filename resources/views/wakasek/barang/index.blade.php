@extends('layouts.wakasek')

@section('title', 'Data Barang (Wakasek)')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
    }

    /* Animasi */
    .table-container {
        animation: fadeSlideIn 0.7s ease forwards;
        opacity: 0;
        transform: translateY(15px);
    }
    @keyframes fadeSlideIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header section */
    .page-header {
        background: linear-gradient(90deg, #2563eb, #1e3a8a);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 14px;
        box-shadow: 0 5px 18px rgba(37, 99, 235, 0.25);
    }
    .page-header h4 {
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    /* Card */
    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    /* Table style */
    .table thead {
        background: #e0e7ff;
        color: #1e3a8a;
        font-weight: 600;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
        padding: 12px;
    }
    .table-hover tbody tr:hover {
        background-color: #f3f6fd;
        transition: background-color 0.2s;
    }

    /* Badge kondisi */
    .badge {
        font-size: 0.85rem;
        padding: 0.45em 0.8em;
        border-radius: 10px;
    }
    .badge.bg-success { background: #16a34a !important; }
    .badge.bg-danger { background: #dc2626 !important; }

    /* Buttons */
    .btn-action {
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .btn-success {
        background: linear-gradient(90deg, #16a34a, #22c55e);
        border: none;
        font-weight: 600;
        border-radius: 50px;
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        .btn-action {
            padding: 5px 8px;
            font-size: 13px;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Data Barang</h4>
        <a href="{{ route('wakasek.barang.create') }}" class="btn btn-success d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>
    </div>

    <!-- Table Card -->
    <div class="card table-container">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Tanggal Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-semibold text-primary">{{ $b->kode_barang }}</span></td>
                            <td class="text-start">{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->jumlah }}</td>
                            <td>
                                <span class="badge bg-{{ $b->kondisi == 'Rusak' ? 'danger' : 'success' }}">
                                    {{ $b->kondisi }}
                                </span>
                            </td>
                            <td>{{ $b->lokasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('wakasek.barang.edit', $b->id) }}" 
                                       class="btn btn-warning btn-action text-white" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-action btn-delete" 
                                            data-id="{{ $b->id }}" 
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inboxes"></i><br>
                                Belum ada data barang 😔
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Hapus barang
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                let barangId = this.dataset.id;
                Swal.fire({
                    title: 'Yakin mau hapus data ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.action = `/wakasek/barang/${barangId}`;
                        form.method = 'POST';
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // Notif sukses
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        @endif
    });
</script>
@endsection
