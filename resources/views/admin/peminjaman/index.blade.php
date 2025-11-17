@extends('layouts.admin')
@section('title', 'Data Peminjaman')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-book-half me-2"></i>Data Peminjaman</h3>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th style="width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $p)
                        <tr>
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
    <div class="d-flex justify-content-center gap-1">
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
        <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST" class="d-inline form-delete">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                <i class="bi bi-inbox" style="font-size:1.5rem;"></i><br>
                                Belum ada data peminjaman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $peminjamans->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('.form-delete');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
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
