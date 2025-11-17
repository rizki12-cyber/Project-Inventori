@extends('layouts.admin')

@section('title', 'Data Program Keahlian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-biru-tua shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-graduation-cap me-3"></i>
                                Data Program Keahlian
                            </h2>
                            <p class="text-white mb-0 mt-2 opacity-75">
                                Kelola program keahlian yang tersedia di sistem
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.programkeahlian.create') }}" 
                                class="btn btn-primary btn-lg rounded-pill shadow-sm"
                                style="background:#3b82f6; border:none; color:white;">
                                     <i class="fas fa-plus me-2"></i>
                                Tambah Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notification -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-white py-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>
                                Daftar Program Keahlian
                            </h5>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                Total: {{ count($programs) }} Program
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light bg-opacity-50">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase text-secondary font-weight-bold" style="width: 80px;">No</th>
                                    <th class="py-3 text-uppercase text-secondary font-weight-bold">Nama Program Keahlian</th>
                                    <th class="text-center py-3 text-uppercase text-secondary font-weight-bold" style="width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $i => $program)
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">{{ $i + 1 }}</span>
                                        </td>

                                        <!-- IKON DIHAPUS SESUAI PERMINTAAN -->
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0 text-dark">{{ $program->nama_program }}</h6>
                                                    <small class="text-muted">Program Keahlian</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.programkeahlian.edit', $program->id) }}" 
                                                   class="btn btn-outline-warning btn-sm rounded-pill px-3 py-2 d-flex align-items-center">
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>

                                                <!-- SWEETALERT DELETE -->
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 d-flex align-items-center" onclick="hapusProgram('{{ $program->id }}', '{{ $program->nama_program }}')">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>

                                                <form id="delete-form-{{ $program->id }}" action="{{ route('admin.programkeahlian.destroy', $program->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="icon-shape bg-light bg-opacity-25 text-primary rounded-circle p-4 mb-3 d-inline-block">
                                                    <i class="fas fa-inbox fs-1"></i>
                                                </div>
                                                <h5 class="text-muted mb-3">Belum ada data program keahlian</h5>
                                                <p class="text-muted mb-4">Mulai dengan menambahkan program keahlian pertama Anda</p>
                                                <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                                    <i class="fas fa-plus me-2"></i>
                                                    Tambah Program Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if(count($programs) > 0)
                <div class="card-footer bg-white py-3 border-top">
                    <p class="mb-0 text-muted">Menampilkan <strong>{{ count($programs) }}</strong> program keahlian</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SWEETALERT CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapusProgram(id, nama) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Program ' + nama + ' akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74a3b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

<style>
.header-biru-tua {
    background: #1e3a8a !important;
    border: none !important;
}
.header-biru-tua * { color: #ffffff !important; }
.card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
.card:hover { box-shadow: 0 8px 15px rgba(0,0,0,0.08); }
.icon-shape { width:40px; height:40px; display:flex; align-items:center; justify-content:center; }
.table-hover tbody tr:hover { background:rgba(52,152,219,0.05); }
</style>

<script>
// SweetAlert Berhasil Input
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 1800,
    showConfirmButton: false
});
@endif
</script>

@endsection
