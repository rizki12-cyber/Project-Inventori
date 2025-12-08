@extends('layouts.admin')

@section('title', 'Data Barang Keluar')

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

/* SEARCH BAR */
.search-container form {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.search-container input,
.search-container button,
.search-container .btn-reset {
    height: 42px;
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    border-radius: 8px;
}
.search-container input {
    border: 1px solid #cbd5e1;
    padding: 0 1rem;
    width: 220px;
}
.search-container button {
    padding: 0 1.1rem;
    border: none;
    background: #2563eb;
    color: white;
}
.search-container button:hover { background: #1e40af; transform: translateY(-2px); }

.search-container .btn-reset {
    padding: 0 1.1rem;
    background: #6b7280;
    color: white;
    border: none;
}
.search-container .btn-reset:hover { background: #4b5563; transform: translateY(-2px); }

/* Responsive search bar */
@media (max-width: 576px) {
    .search-container form {
        flex-wrap: nowrap !important;
        width: 100%;
        gap: 0.4rem;
    }
    .search-container input {
        flex: 1;
        min-width: 0;
    }
    .search-container button,
    .search-container .btn-reset {
        font-size: 0.8rem;
        white-space: nowrap;
    }
    .page-title { font-size: 1.3rem !important; }
}

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

/* Empty state */
.empty-state { text-align:center; padding:3rem 1rem; color:#94a3b8; }
.empty-state i { font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1; }
</style>

<div class="container py-5 data-container">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title">
            <i class="bi bi-box-arrow-up me-2"></i>
            Data Barang Keluar
        </h2>

        <a href="{{ route('admin.barangkeluar.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Barang Keluar
        </a>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-container mb-4">
        <form action="{{ route('admin.barangkeluar.index') }}" method="GET">
            <input type="text" name="search" placeholder="Cari barang / lokasi / penerima..."
                   value="{{ request('search') }}">

            <button type="submit"><i class="bi bi-search"></i> Cari</button>

            @if(request('search'))
                <a href="{{ route('admin.barangkeluar.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    <!-- Card Table -->
    <div class="card p-4">
        @if($barangKeluar->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Jumlah</th>
                        <th>Lokasi</th>
                        <th>Penerima</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($barangKeluar as $index => $bk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bk->barang->nama_barang ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}</td>
                        <td>{{ $bk->jumlah }}</td>
                        <td>{{ $bk->lokasi ?? '-' }}</td>
                        <td>{{ $bk->penerima ?? '-' }}</td>
                        <td>{{ $bk->keterangan ?? '-' }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <!-- Edit -->
                                <a href="{{ route('admin.barangkeluar.edit', $bk->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.barangkeluar.destroy', $bk->id) }}"
                                      method="POST"
                                      class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
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

        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <div>Belum ada data barang keluar</div>
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
