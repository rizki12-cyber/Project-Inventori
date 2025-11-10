@extends('layouts.wakasek')

@section('title', 'Data Barang (Wakasek)')

@section('content')
<style>
    .table-container {
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-action {
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.5em 0.75em;
        border-radius: 12px;
        font-weight: 500;
    }

    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: #f3f6fd;
    }

    /* Card shadow */
    .card {
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    }

    /* Responsive adjustments */
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
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h4 class="fw-bold text-primary">📦 Data Barang</h4>
        <a href="{{ route('wakasek.barang.create') }}" class="btn btn-success shadow-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>
    </div>

    <div class="card table-container">
        <div class="card-body table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center text-uppercase">
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
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->kode_barang }}</td>
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
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('wakasek.barang.edit', $b->id) }}" class="btn btn-warning btn-action text-white" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-action btn-delete" data-id="{{ $b->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
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

        // Hapus dengan SweetAlert
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                let barangId = this.dataset.id;
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form dinamis untuk delete
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

        // Notifikasi success
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
