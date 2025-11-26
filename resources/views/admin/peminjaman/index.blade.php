@extends('layouts.admin')
@section('title', 'Data Peminjaman')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Animation */
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
}

/* Add Button */
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

/* Buttons */
.btn-sm { border-radius: 10px; width: 36px; height: 36px; display:flex; justify-content:center; align-items:center; transition:0.25s; }
.btn-warning { background:#facc15; border:none; }
.btn-warning:hover { background:#eab308; transform:translateY(-2px); }
.btn-danger { background:#ef4444; border:none; }
.btn-danger:hover { background:#dc2626; transform:translateY(-2px); }
.btn-success { background:#22c55e; border:none; }
.btn-success:hover { background:#16a34a; transform:translateY(-2px); }

/* Status Badge */
.badge { padding:0.35em 0.65em; border-radius: 10px; font-weight:500; }

/* Empty state */
.empty-state { text-align:center; padding:3rem 1rem; color:#94a3b8; }
.empty-state i { font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1; }

/* Search & Filter */
.form-search-filter { margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
.form-search-filter input,
.form-search-filter select { border-radius: 10px; border: 1px solid #cbd5e1; padding: 0.5rem; width: 200px; transition: 0.3s; }
.form-search-filter input:focus,
.form-search-filter select:focus { border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37,99,235,0.2); outline: none; }
.form-search-filter button { border-radius: 10px; padding: 0.45rem 1rem; transition: 0.25s; }
.form-search-filter .btn-secondary { background:#f1f5f9; border:none; color:#334155; }
.form-search-filter .btn-secondary:hover { background:#e2e8f0; }
</style>

<div class="container py-5 data-container">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title">
            <i class="bi bi-book-half me-2"></i>
            Data Peminjaman
        </h2>

        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Peminjaman
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" class="form-search-filter">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / barang..." />
        <select name="status">
            <option value="">-- Semua Status --</option>
            <option value="Dipinjam" {{ request('status')=='Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="Dikembalikan" {{ request('status')=='Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
        <button class="btn btn-primary">Cari</button>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <!-- Card Table -->
    <div class="card p-4">
        @if($peminjamans->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->nama_peminjam }}</td>
                        <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $p->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') : '-' }}</td>
                        <td>{{ $p->kondisi ?? '-' }}</td>
                        <td>
                            @php
                                $statusClass = match($p->status) {
                                    'Dipinjam' => 'bg-warning text-dark',
                                    'Dikembalikan' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $p->status }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                @if($p->status === 'Dipinjam')
                                <form action="{{ route('admin.peminjaman.kembalikan', $p->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Kembalikan">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('admin.peminjaman.edit', $p->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST"
                                      class="d-inline form-delete">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $peminjamans->links() }}
        </div>

        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <div>Belum ada data peminjaman</div>
        </div>
        @endif
    </div>
</div>

<script>
// Delete Confirmation
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('.form-delete');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

// Success Notification
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
