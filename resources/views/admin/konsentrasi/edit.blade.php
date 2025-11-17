@extends('layouts.admin')

@section('title', 'Edit Konsentrasi Keahlian')

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
                                <i class="fas fa-edit me-3"></i>
                                Edit Konsentrasi Keahlian
                            </h2>
                            <p class="text-white mb-0 mt-2 opacity-75">
                                Perbarui data konsentrasi keahlian yang dipilih
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
                        <i class="fas fa-pencil-alt me-2"></i>
                        Form Edit Konsentrasi Keahlian
                    </h5>
                </div>

                <div class="card-body px-4 py-4">

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.konsentrasi.update', $konsentrasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Program Keahlian -->
                        <div class="mb-4">
                            <label for="program_keahlian_id" class="form-label fw-semibold">
                                Program Keahlian
                            </label>
                            <select name="program_keahlian_id" 
                                    id="program_keahlian_id" 
                                    class="form-select form-select-lg rounded-3"
                                    style="height:55px;" required>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ $konsentrasi->program_keahlian_id == $program->id ? 'selected' : '' }}>
                                        {{ $program->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Konsentrasi -->
                        <div class="mb-4">
                            <label for="nama_konsentrasi" class="form-label fw-semibold">
                                Nama Konsentrasi
                            </label>
                            <input type="text"
                                   id="nama_konsentrasi"
                                   name="nama_konsentrasi"
                                   class="form-control form-control-lg rounded-3"
                                   value="{{ old('nama_konsentrasi', $konsentrasi->nama_konsentrasi) }}"
                                   placeholder="Masukkan nama konsentrasi keahlian..."
                                   required
                                   style="height:55px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Perbarui
                        </button>

                        <a href="{{ route('admin.konsentrasi.index') }}" 
                           class="btn btn-secondary btn-lg rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- SWEETALERT SUCCESS -->
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
