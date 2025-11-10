@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<!-- Pastikan Bootstrap Icons sudah dipanggil di layouts.admin -->
<style>
    /* Animasi fade-slide untuk container */
    .data-container {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeSlideIn 0.8s forwards;
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .table tbody tr:hover {
        background-color: #f1f3f5;
        transition: background-color 0.2s;
    }

    .btn-primary {
        border-radius: 50px;
        padding: 0.5rem 1.2rem;
        transition: background-color 0.2s, transform 0.2s;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: scale(1.05);
    }
    .btn-sm {
        border-radius: 8px;
        min-width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .btn-warning:hover {
        transform: scale(1.05);
    }
    .btn-danger:hover {
        transform: scale(1.05);
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.4em 0.7em;
        border-radius: 12px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    th.aksi, td.aksi {
        min-width: 120px;
    }

    .action-buttons {
        display: flex;
        gap: 0.3rem;
        flex-wrap: wrap;
    }
</style>

<div class="container mt-5 data-container">
    <h2 class="mb-4 text-primary">Data Barang</h2>

    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Barang
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Tanggal Pembelian</th>
                            <th class="aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->jumlah }}</td>
                            <td>
                                @php
                                    $badgeClass = $b->kondisi == 'Baik' ? 'success' : ($b->kondisi == 'Rusak' ? 'danger' : 'secondary');
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $b->kondisi }}</span>
                            </td>
                            <td>{{ $b->lokasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d M Y') }}</td>
                            <td class="aksi">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.barang.edit', $b->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.barang.destroy', $b->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data barang</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
