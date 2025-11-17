@extends('layouts.admin')

@section('title', 'Tambah Program Keahlian')

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
                                <i class="fas fa-plus-circle me-3"></i>
                                Tambah Program Keahlian
                            </h2>
                            <p class="text-white mb-0 mt-2 opacity-75">
                                Tambahkan program keahlian baru ke dalam sistem
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-white py-4 border-bottom">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-edit me-2"></i>
                        Form Tambah Program Keahlian
                    </h5>
                </div>

                <div class="card-body px-4 py-4">

                    <form action="{{ route('admin.programkeahlian.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_program" class="form-label fw-semibold">
                                Nama Program Keahlian
                            </label>
                            <input type="text" 
                                   name="nama_program" 
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Masukkan nama program keahlian..."
                                   required
                                   style="height:55px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                        <a href="{{ route('admin.programkeahlian.index') }}" 
                           class="btn btn-secondary btn-lg rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- SWEETALERT SUCCESS INPUT -->
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 1800,
            showConfirmButton: false
        });
    </script>
@endif

<style>
.header-biru-tua {
    background: #1e3a8a !important;
}
.header-biru-tua * {
    color: white !important;
}
</style>

@endsection
