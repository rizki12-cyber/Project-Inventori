@extends('layouts.admin')

@section('title', 'Data Program Keahlian')

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

/* Empty state */
.empty-state { text-align:center; padding:3rem 1rem; color:#94a3b8; }
.empty-state i { font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1; }
</style>

<div class="container py-5 data-container">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title">
            <i class="fas fa-graduation-cap me-2"></i>
            Data Program Keahlian
        </h2>

        <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-add">
            <i class="fas fa-plus-circle"></i> +Tambah Program
        </a>
    </div>

    <!-- Card Table -->
    <div class="card p-4">
        @if($programs->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Keahlian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($programs as $index => $program)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $program->nama_program }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <!-- Edit -->
                                <a href="{{ route('admin.programkeahlian.edit', $program->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.programkeahlian.destroy', $program->id) }}"
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
            <div>Belum ada data program keahlian</div>
            <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-add mt-3">
                <i class="fas fa-plus-circle"></i> Tambah Program Pertama
            </a>
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
