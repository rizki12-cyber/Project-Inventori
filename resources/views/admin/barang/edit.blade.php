@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        font-family: 'Poppins', sans-serif;
    }

    .form-container {
        animation: fadeInUp 0.8s ease forwards;
        opacity: 0;
        transform: translateY(25px);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: linear-gradient(120deg, #2563eb, #1e40af);
        color: white;
        border-radius: 18px;
        padding: 1.5rem 2rem;
        box-shadow: 0 8px 20px rgba(37,99,235,0.25);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        overflow: hidden;
        position: relative;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
    }

    .page-header h2 { font-weight: 600; z-index: 1; }

    .card {
        border-radius: 20px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        border: none;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.12);
    }

    .form-label { font-weight: 500; color: #1e293b; }
    .form-control { border-radius: 10px; padding: 0.6rem 1rem; border: 1.5px solid #cbd5e1; transition: all 0.3s ease; }
    .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.15); }

    .btn-success {
        background: linear-gradient(120deg, #16a34a, #15803d);
        border: none;
        border-radius: 50px;
        padding: 0.6rem 1.4rem;
        font-weight: 500;
        transition: 0.3s;
        box-shadow: 0 4px 12px rgba(22,163,74,0.25);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22,163,74,0.35);
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #1e293b;
        border-radius: 50px;
        padding: 0.6rem 1.4rem;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background: #cbd5e1;
        transform: translateY(-2px);
    }

    .alert-danger {
        border-radius: 12px;
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        box-shadow: 0 4px 12px rgba(239,68,68,0.15);
    }

    .img-preview { max-width: 150px; margin-top: 0.5rem; border-radius: 10px; }
</style>

<div class="container py-5 form-container">

    <!-- Header -->
    <div class="page-header">
        <h2><i class="bi bi-pencil-square me-2"></i>Edit Barang</h2>
        <a href="{{ route('admin.barang.index') }}" class="btn btn-light rounded-pill shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Form -->
    <div class="card p-4">
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- enctype untuk upload -->
        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $barang->kategori) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $barang->jumlah) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        @php $kondisi = old('kondisi', $barang->kondisi); @endphp
                        <option value="Baik" {{ $kondisi=='Baik'?'selected':'' }}>Baik</option>
                        <option value="Rusak" {{ $kondisi=='Rusak'?'selected':'' }}>Rusak</option>
                        <option value="Hilang" {{ $kondisi=='Hilang'?'selected':'' }}>Hilang</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $barang->lokasi) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control"value="{{ old('tanggal_pembelian', \Carbon\Carbon::parse($barang->tanggal_pembelian)->format('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Penghapusan</label>
                    <input type="date" name="tanggal_penghapusan" class="form-control" value="{{ old('tanggal_penghapusan', $barang->tanggal_penghapusan) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sumber Dana</label>
                    <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana', $barang->sumber_dana) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Foto Barang</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @if($barang->foto)
                        <img src="{{ asset('storage/'.$barang->foto) }}" alt="Foto Barang" class="img-preview">
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                </div>

                <div class="col-12">
    <label class="form-label">Spesifikasi</label>
    <textarea name="spesifikasi" class="form-control" rows="3">{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
</div>

            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1800
    });
</script>
@endif
@endsection
