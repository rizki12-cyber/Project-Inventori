@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Basic body & animation */
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.data-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }
@keyframes fadeSlideIn { to { opacity: 1; transform: translateY(0); } }

/* Page Title */
.page-title {
    font-weight: 700;
    font-size: 1.8rem;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
}

/* Add button */
.btn-add {
    background: #ffffff;
    color: #1e40af;
    border-radius: 50px;
    padding: 0.55rem 1.2rem;
    font-weight: 500;
    display: flex; align-items: center; gap: 0.4rem;
    transition: 0.3s;
}
.btn-add:hover { background: #e0e7ff; transform: translateY(-2px); }

/* Card & Table */
.card { border: none; border-radius: 20px; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
.table { border-collapse: separate; border-spacing: 0 0.5rem; text-align: center; }
.table thead { background: #f1f5f9; color: #334155; font-weight: 600; }
.table tbody tr { background: #fff; border-radius: 10px; transition: 0.25s; }
.table tbody tr:hover { transform: scale(1.01); background-color: #f8fafc; box-shadow: 0 3px 10px rgba(37,99,235,0.1); }

/* Badge & Buttons */
.badge { font-size: 0.8rem; padding: 0.4em 0.8em; border-radius: 8px; font-weight: 500; }
.btn-sm { border-radius: 10px; display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px; transition: 0.25s; }
.btn-warning { background: #facc15; border: none; color: #1e293b; }
.btn-warning:hover { background: #eab308; transform: translateY(-2px); }
.btn-danger { background: #ef4444; border: none; color: #fff; }
.btn-danger:hover { background: #dc2626; transform: translateY(-2px); }

/* Empty state */
.empty-state { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 0.5rem; color: #cbd5e1; }

/* Foto thumbnail */
.foto-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }

/* Search box */
.search-box { position: relative; width: 250px; }
.search-box input { padding-right: 2.5rem; }
.search-box i { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #64748b; }
</style>

<div class="container py-5 data-container">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title"><i class="bi bi-box-seam me-2"></i>Data Barang</h2>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-add"><i class="bi bi-plus-circle"></i> Tambah Barang</a>
    </div>

    <!-- FILTER LOKASI -->
    <div class="d-flex justify-content-start mb-3">
        <form action="{{ route('admin.barang.index') }}" method="GET" class="d-flex gap-2">
            <select name="lokasi" class="form-control" style="width: 220px;">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($listLokasi as $lok)
                    <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>
                        {{ $lok }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn" style="background:#0d6efd;color:white;">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <!-- Table -->
    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle" id="barangTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Tgl Pembelian</th>
                        <th>Tgl Penghapusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($barang as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($b->foto)
                                <img src="{{ asset('storage/foto_barang/' . $b->foto) }}" class="foto-thumb" alt="Foto">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $b->nama_barang }}</td>
                        <td>{{ $b->lokasi ?? '-' }}</td>
                        <td>{{ $b->tanggal_pembelian ? \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d M Y') : '-' }}</td>
                        <td>{{ $b->tanggal_penghapusan ? \Carbon\Carbon::parse($b->tanggal_penghapusan)->format('d M Y') : '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.barang.show', $b->id) }}" class="btn btn-sm btn-info" title="Detail"
                                   style="background:#0ea5e9;border:none;color:white;">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.barang.edit', $b->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.barang.destroy', $b->id) }}" method="POST" class="d-inline form-delete">
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
                        <td colspan="12" class="empty-state">
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
// SweetAlert Delete Confirmation
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('.form-delete');
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => { if (result.isConfirmed) form.submit(); });
    });
});

// SweetAlert Success Alerts
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
