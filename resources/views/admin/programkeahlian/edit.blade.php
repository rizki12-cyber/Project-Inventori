@extends('layouts.admin')

@section('title', 'Edit Program Keahlian')

@section('content')
<div class="container mt-4">
    <h2>Edit Program Keahlian</h2>

    <form action="{{ route('admin.programkeahlian.update', $program->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_program" class="form-label">Nama Program Keahlian</label>
            <input type="text" class="form-control" name="nama_program" value="{{ $program->nama_program }}" required>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('admin.programkeahlian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
