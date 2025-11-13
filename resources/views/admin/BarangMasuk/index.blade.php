@extends('layouts.admin')

@section('title', 'Data Barang Masuk')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Barang Masuk</h3>
        <a href="{{ route('admin.barangmasuk.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Barang Masuk
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Barang</th>
                            <th>Supplier</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah</th>
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangMasuk as $index => $bm)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $bm->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $bm->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d M Y') }}</td>
                            <td>{{ $bm->jumlah }}</td>
                            <td>
                                <form action="{{ route('admin.barangmasuk.destroy', $bm->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                <i class="bi bi-inbox" style="font-size:1.5rem;"></i> <br>
                                Belum ada data barang masuk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Jika menggunakan pagination --}}
            {{-- <div class="mt-3 d-flex justify-content-end">
                {{ $barangMasuk->links() }}
            </div> --}}
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
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

// Optional: Notifikasi sukses
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
