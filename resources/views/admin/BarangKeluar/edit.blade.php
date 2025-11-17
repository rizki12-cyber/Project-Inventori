@extends('layouts.admin')

@section('title', 'Edit Barang Keluar')

@section('content')
<div class="container py-4">

    <h3 class="mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Barang Keluar</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.barangkeluar.update', $barangKeluar->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <select name="id_barang" class="form-select" required>
        <option value="" disabled>Pilih Barang</option>

        @foreach($barang as $b)
            <option value="{{ $b->id }}" 
                {{ (old('id_barang', $barangKeluar->id_barang) == $b->id) ? 'selected' : '' }}>
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
</div>


                <div class="mb-3">
                    <label class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" 
                           value="{{ $barangKeluar->tanggal_keluar }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control"
                           value="{{ $barangKeluar->jumlah }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                           value="{{ $barangKeluar->lokasi }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penerima</label>
                    <input type="text" name="penerima" class="form-control"
                           value="{{ $barangKeluar->penerima }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ $barangKeluar->keterangan }}</textarea>
                </div>

                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <a href="{{ route('admin.barangkeluar.index') }}" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>
@endsection
