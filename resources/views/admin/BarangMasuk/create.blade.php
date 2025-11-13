@extends('layouts.admin')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Tambah Barang Masuk</h3>

    <form action="{{ route('admin.barangmasuk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Barang</label>
            <select name="id_barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                @foreach ($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Supplier</label>
            <select name="id_supplier" class="form-select" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach ($suppliers as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.barangmasuk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
