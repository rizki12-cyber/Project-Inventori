@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.data-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }
@keyframes fadeSlideIn { to { opacity: 1; transform: translateY(0); } }

/* Page Title */
.page-title {
    font-weight: 700;
    font-size: clamp(1.4rem, 3vw, 1.9rem);
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: .6rem;
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
    white-space: nowrap;
}
.btn-add:hover { background: #e0e7ff; transform: translateY(-2px); }

/* Card & Table */
.card { border: none; border-radius: 20px; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
.table { border-collapse: separate; border-spacing: 0 0.5rem; text-align: center; min-width: 700px; }
.table thead { background: #f1f5f9; color: #334155; font-weight: 600; }
.table tbody tr { background: #fff; border-radius: 10px; transition: 0.25s; }
.table tbody tr:hover { transform: scale(1.01); background-color: #f8fafc; box-shadow: 0 3px 10px rgba(37,99,235,0.1); }

/* Foto */
.foto-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

/* Tombol */
.btn-sm { border-radius: 10px; width: 36px; height: 36px; display: inline-flex; justify-content:center;align-items:center; }
.btn-warning { background: #facc15; border: none; color: #1e293b; }
.btn-danger { background: #ef4444; border: none; color: #fff; }
.btn-info { background: #0ea5e9 !important; border: none; }

/* Empty */
.empty-state { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
.empty-state i { font-size: 3rem; color: #cbd5e1; }

/* Search box */
.search-box { position: relative; width: 250px; }
.search-box input { padding-right: 2.5rem; }

/* ============================
   RESPONSIVE AREA
   ============================ */
@media (max-width: 992px) {
    .foto-thumb { width: 50px; height: 50px; }
}

@media (max-width: 768px) {
    .d-flex.align-items-center.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }

    form.d-flex.gap-2 {
        flex-wrap: wrap;
        width: 100%;
    }

    form.d-flex.gap-2 select,
    form.d-flex.gap-2 button,
    form.d-flex.gap-2 a {
        width: 100%;
    }

    .foto-thumb { width: 45px; height: 45px; }
}

@media (max-width: 576px) {
    .btn-sm { width: 32px; height: 32px; }
    .foto-thumb { width: 40px; height: 40px; }
}
</style>

<div class="container py-5 data-container">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title"><i class="bi bi-box-seam"></i> Data Barang</h2>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>
    </div>

    <!-- FILTER -->
    <div class="d-flex justify-content-start mb-3 flex-wrap">
        <form action="{{ route('admin.barang.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <select name="lokasi" class="form-control" style="width: 220px;">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($listLokasi as $lok)
                    <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>
                        {{ $lok }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <!-- TABLE -->
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
                                <img src="{{ asset('storage/foto_barang/' . $b->foto) }}" class="foto-thumb">
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
                                <a href="{{ route('admin.barang.show', $b->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.barang.edit', $b->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.barang.destroy', $b->id) }}" method="POST" class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
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
// Delete Confirmation
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
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });
});

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
