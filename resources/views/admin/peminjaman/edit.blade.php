@extends('layouts.admin')
@section('title', 'Edit Peminjaman')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Peminjaman</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ $barang->id == $peminjaman->barang_id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $peminjaman->jumlah) }}" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kondisi</label>
                        <input type="text" name="kondisi" value="{{ old('kondisi', $peminjaman->kondisi) }}" class="form-control" placeholder="Contoh: Baik/Rusak">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Dipinjam" {{ $peminjaman->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
