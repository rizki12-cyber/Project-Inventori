@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    display: flex; 
    align-items: center;
}
.page-title i { margin-right: 0.5rem; }

/* Card */
.card { border: none; border-radius: 20px; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }

/* Form Inputs */
.form-label { font-weight: 600; }
input.form-control { border-radius: 10px; padding: 0.6rem 0.75rem; }

/* Buttons */
.btn-primary { border-radius: 10px; transition: 0.3s; }
.btn-primary:hover { transform: translateY(-2px); }

/* Image Preview */
.img-thumbnail { border-radius: 10px; }

/* Empty state */
.empty-state { text-align:center; padding:3rem 1rem; color:#94a3b8; }
.empty-state i { font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1; }
</style>

<div class="container py-5 data-container">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="page-title">
            <i class="bi bi-gear-fill"></i>
            Pengaturan Website
        </h2>
    </div>

    <!-- Card Form -->
    <div class="card p-4">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Sekolah --}}
            <div class="mb-4">
                <label class="form-label">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" 
                       class="form-control"
                       value="{{ $pengaturan->nama_sekolah ?? '' }}"
                       placeholder="Masukkan nama sekolah" required>
            </div>

            <div class="row">
                {{-- Logo Sekolah --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label">Logo Sekolah</label>
                    <div class="mb-2">
                        <img id="previewLogoSekolah" 
                             src="{{ asset($pengaturan->logo_sekolah ?? 'assets/default/logo.png') }}" 
                             class="img-thumbnail mb-2" 
                             style="max-height: 120px; object-fit: contain;">
                    </div>
                    <input type="file" name="logo_sekolah" class="form-control" 
                           accept="image/*" onchange="previewImage(event, 'previewLogoSekolah')">
                </div>

                {{-- Favicon --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label">Favicon</label>
                    <div class="mb-2">
                        <img id="previewFavicon" 
                             src="{{ asset($pengaturan->favicon ?? 'assets/default/favicon.png') }}" 
                             class="img-thumbnail mb-2" 
                             style="max-height: 80px; object-fit: contain;">
                    </div>
                    <input type="file" name="favicon" class="form-control" 
                           accept="image/*" onchange="previewImage(event, 'previewFavicon')">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 mt-3">
                Simpan Pengaturan
            </button>
        </form>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById(previewId).src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

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
