@extends('layouts.kabeng')

@section('title', 'Tambah Barang (Kabeng)')

@section('content')

<style>
    .form-container {
        animation: fadeSlideIn 0.8s forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .btn-submit {
        background: #2563eb;
        color: #fff;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 25px;
        font-weight: 600;
    }

    .btn-submit:hover {
        background: #1e3a8a;
    }
</style>

<div class="container py-4 form-container">
    <div class="card p-4">
        <h4 class="fw-bold mb-3 text-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Barang Kabeng
        </h4>

        <form action="{{ route('kabeng.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" placeholder="Contoh: Komputer, Kursi, Meja" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Detail barang..."></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-control" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Lab RPL 1" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sumber Dana</label>
                    <input type="text" name="sumber_dana" class="form-control" placeholder="Contoh: BOS, Komite, Hibah">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Penghapusan (opsional)</label>
                    <input type="date" name="tanggal_penghapusan" class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Foto Barang</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
