@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background: linear-gradient(135deg, #e0e7ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
    }
    .data-container {
        animation: fadeUp 0.8s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .header-bar {
        background: linear-gradient(120deg, #2563eb, #1e40af);
        border-radius: 20px;
        padding: 1.8rem 2rem;
        color: white;
        box-shadow: 0 8px 20px rgba(37,99,235,0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }
    .header-bar::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
    }
    .header-bar h2 { font-weight: 600; letter-spacing: 0.5px; z-index: 1; }
    .btn-add {
        background: #ffffff;
        color: #1e40af;
        border-radius: 50px;
        font-weight: 500;
        padding: 0.65rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: 0.3s;
    }
    .btn-add:hover { background: #e0e7ff; transform: translateY(-2px); box-shadow: 0 3px 10px rgba(37,99,235,0.25); }
    .card { border: none; border-radius: 20px; background: white; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; backdrop-filter: blur(15px); }
    table { border-collapse: separate; border-spacing: 0 0.6rem; }
    .table thead { background: #f1f5f9; color: #334155; font-weight: 600; }
    .table tbody tr { background: #fff; border-radius: 10px; transition: 0.25s; }
    .table tbody tr:hover { transform: scale(1.01); background-color: #f8fafc; box-shadow: 0 3px 10px rgba(37,99,235,0.1); }
    .badge { font-size: 0.8rem; padding: 0.4em 0.8em; border-radius: 8px; font-weight: 500; }
    .btn-sm { border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; transition: 0.25s; }
    .btn-warning { background: #facc15; border: none; color: #1e293b; }
    .btn-warning:hover { background: #eab308; transform: translateY(-2px); }
    .btn-danger { background: #ef4444; border: none; color: white; }
    .btn-danger:hover { background: #dc2626; transform: translateY(-2px); }
    .empty-state { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
    .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 0.5rem; }
    .foto-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
</style>

<div class="container py-5 data-container">
    <!-- Header -->
    <div class="header-bar mb-4">
        <h2><i class="bi bi-box-seam me-2"></i>Data Barang</h2>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>
    </div>

    <!-- Search -->
    <div class="d-flex justify-content-end mb-3">
        <div class="search-box">
            <input type="text" class="form-control" id="searchInput" placeholder="Cari barang...">
            <i class="bi bi-search"></i>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle text-center" id="barangTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Tanggal Pembelian</th>
                        <th>Sumber Dana</th>
                        <th>Tanggal Penghapusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($b->foto)
                                <img src="{{ asset('storage/foto_barang/' . $b->foto) }}" alt="Foto" class="foto-thumb">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $b->nama_barang }}</td>
                        <td>{{ $b->kategori }}</td>
                        <td>{{ $b->spesifikasi ?? '-' }}</td> <!-- ✅ Menampilkan spesifikasi -->
                        <td>{{ $b->jumlah }}</td>
                        <td>
                            @php
                                $badgeClass = match($b->kondisi) {
                                    'Baik' => 'bg-success',
                                    'Rusak' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $b->kondisi }}</span>
                        </td>
                        <td>{{ $b->lokasi }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d M Y') }}</td>
                        <td>{{ $b->sumber_dana ?? '-' }}</td>
                        <td>{{ $b->tanggal_penghapusan ? \Carbon\Carbon::parse($b->tanggal_penghapusan)->format('d M Y') : '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.barang.edit', $b->id) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.barang.destroy', $b->id) }}" 
                                      method="POST" 
                                      class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <div>Belum ada data barang</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Live Search
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll("#barangTable tbody tr").forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });

    // SweetAlert Delete Confirmation
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data yang dihapus gak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // SweetAlert Success Alerts (tambah, edit, hapus)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1800
        });
    @endif
</script>
@endsection
