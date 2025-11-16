@extends('layouts.wakasek')

@section('title', 'Profil Wakasek')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-10">

            <!-- Card Profil -->
            <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn">
                
                <!-- Header -->
                <div class="card-header bg-primary text-white rounded-top-4 py-4 text-center position-relative">
                    <h4 class="mb-0 fw-bold">Profil Wakasek</h4>
                    <p class="mb-0 text-white-50 small">Manajemen data profil Wakil Kepala Sekolah</p>
                </div>

                <!-- Body -->
                <div class="card-body p-4">

                    <!-- Foto Profil -->
                    <div class="text-center mb-4">
                        <img src="{{ $wakasek->avatar ? asset('storage/' . $wakasek->avatar) : asset('default/user.png') }}" 
                             class="rounded-circle border shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>

                    <!-- FORM -->
                    <form action="{{ route('wakasek.profile.update') }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="row g-3">

                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control shadow-sm"
                                   value="{{ $wakasek->nama }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" class="form-control shadow-sm"
                                   value="{{ $wakasek->nip }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm"
                                   value="{{ $wakasek->jabatan }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm"
                                   value="{{ $wakasek->email }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control shadow-sm"
                                   value="{{ $wakasek->no_hp }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Foto Profil (Opsional)</label>
                            <input type="file" name="avatar" class="form-control shadow-sm">
                            <small class="text-muted">Ukuran max: 2MB | Format: JPG, PNG</small>
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-primary px-4 py-2 shadow-sm w-100 fw-semibold">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<style>
    body {
        font-family: "Poppins", sans-serif;
    }

    .card {
        transition: 0.25s ease-in-out;
    }
    .card:hover {
        transform: translateY(-3px);
    }

    .form-control {
        border-radius: 10px;
    }

    .btn {
        border-radius: 10px;
    }
</style>

@endsection
