@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<style>
    /* Animasi fade-slide untuk container */
    .form-container {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeSlideIn 0.8s forwards;
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card & shadow */
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    /* Tombol */
    .btn-success, .btn-secondary {
        border-radius: 50px;
        padding: 0.5rem 1.2rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-success:hover {
        transform: scale(1.05);
    }
    .btn-secondary:hover {
        transform: scale(1.03);
    }

    /* Alert error */
    .alert-danger {
        border-radius: 8px;
    }
</style>

<div class="container mt-5 form-container">
    <h2 class="mb-4 text-primary">Edit Barang</h2>

    <div class="card p-4">
        @if($errors->any())
            <div class="alert alert-danger rounded">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $barang->kategori) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $barang->jumlah) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-control" required>
                    @php $kondisi = old('kondisi', $barang->kondisi); @endphp
                    <option value="Baik" {{ $kondisi=='Baik'?'selected':'' }}>Baik</option>
                    <option value="Rusak" {{ $kondisi=='Rusak'?'selected':'' }}>Rusak</option>
                    <option value="Hilang" {{ $kondisi=='Hilang'?'selected':'' }}>Hilang</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $barang->lokasi) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian', $barang->tanggal_pembelian) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control">{{ old('keterangan', $barang->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-pencil-square"></i> Update
            </button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection
