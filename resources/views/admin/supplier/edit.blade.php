@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<div class="content-card card">
    <div class="card-header">
        <h5>Edit Supplier</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ $supplier->nama_supplier }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>{{ $supplier->alamat }}</textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="telepon" value="{{ $supplier->telepon }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
