@extends('layouts.admin')

@section('title', 'Data Barang Keluar')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-box-arrow-up me-2"></i>Data Barang Keluar</h3>
        <a href="{{ route('admin.barangkeluar.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Barang Keluar
        </a>
    </div>

    <!-- Notifikasi sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-3">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="50px">No</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Keluar</th>
                            <th>Jumlah</th>
                            <th>Lokasi</th>
                            <th>Penerima</th>
                            <th>Keterangan</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($barangKeluar as $index => $bk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $bk->barang->nama_barang ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}</td>
                            <td>{{ $bk->jumlah }}</td>
                            <td>{{ $bk->lokasi ?? '-' }}</td>
                            <td>{{ $bk->penerima ?? '-' }}</td>
                            <td>{{ $bk->keterangan ?? '-' }}</td>

                            <td>

                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.barangkeluar.edit', $bk->id) }}" 
                                    class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.barangkeluar.destroy', $bk->id) }}" 
                                      method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                <i class="bi bi-inbox" style="font-size:1.5rem;"></i><br>
                                Belum ada data barang keluar
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    // Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('.form-delete');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Notif sukses (popup)
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1700
    });
    @endif
</script>

@endsection
