@extends('layouts.kabeng')

@section('title', 'Data Barang (Kabeng)')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
    }

    .data-container {
        animation: fadeSlideIn 0.8s forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .btn-add {
        background: #2563eb;
        color: #fff;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: #1e3a8a;
    }

    .table th {
        background: #2563eb;
        color: white;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .btn-action {
        border-radius: 10px;
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-warning {
        background: #f59e0b;
        border: none;
    }

    .btn-danger {
        background: #ef4444;
        border: none;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .btn-danger:hover {
        background: #dc2626;
    }
</style>

<div class="container-fluid data-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-box-seam me-2"></i>Data Barang Kabeng {{ Auth::user()->jurusan ?? 'RPL' }}
        </h3>
        <a href="{{ route('kabeng.barang.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle me-2"></i>Tambah Barang
        </a>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Tanggal Pembelian</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barang as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>
                                <span class="badge bg-{{ $item->kondisi == 'Rusak' ? 'danger' : 'success' }}">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                @if($item->user_id == Auth::id())
                                    <!-- Kalau barang milik kabeng sendiri -->
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('kabeng.barang.edit', $item->id) }}" 
                                           class="btn btn-warning btn-action text-white">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('kabeng.barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Kalau barang dari admin atau wakasek -->
                                    <span class="text-muted fst-italic">Hanya dapat dilihat</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
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
@endsection
