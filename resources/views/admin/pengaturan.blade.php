@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Pengaturan Website</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3 p-4">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Sekolah --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" 
                       class="form-control p-2"
                       value="{{ $pengaturan->nama_sekolah ?? '' }}"
                       placeholder="Masukkan nama sekolah" required>
            </div>

            <div class="row">
                {{-- Logo Sekolah --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Logo Sekolah</label>
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
                    <label class="form-label fw-semibold">Favicon</label>
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
</script>
@endsection
