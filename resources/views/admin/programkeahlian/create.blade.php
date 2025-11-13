@extends('layouts.admin')

@section('title', 'Tambah Program Keahlian')

@section('content')
<div class="container mt-4">
    <h2>Tambah Program Keahlian</h2>

    <form action="{{ route('admin.programkeahlian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_program" class="form-label">Nama Program Keahlian</label>
            <input type="text" class="form-control" name="nama_program" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.programkeahlian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
