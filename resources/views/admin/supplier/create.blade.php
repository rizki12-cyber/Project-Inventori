@extends('layouts.admin')

@section('title', 'Tambah Supplier')

@section('content')
<div class="content-card card">
    <div class="card-header">
        <h5>Tambah Supplier</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.supplier.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Supplier</label>
                <input type="text" name="nama_supplier" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
