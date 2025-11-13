@extends('layouts.admin')

@section('title', 'Data Supplier')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="mb-0">Data Supplier</h5>
            <a href="{{ route('admin.supplier.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Supplier
            </a>
        </div>
        <div class="card-body">

            @if($suppliers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index + $suppliers->firstItem() }}</td>
                            <td>{{ $supplier->nama_supplier }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->telepon }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $supplier->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $supplier->id }}" action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $suppliers->links() }}
            </div>

            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">Belum ada data supplier.</p>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const supplierId = this.dataset.id;
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data supplier akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + supplierId).submit();
                }
            });
        });
    });

    // Notifikasi sukses
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

    @if(session('deleted'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('deleted') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
});
</script>
@endsection
