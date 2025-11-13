@extends('layouts.admin')

@section('title', 'Tambah Konsentrasi Keahlian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Tambah Konsentrasi Keahlian</h3>

    <form action="{{ route('admin.konsentrasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="program_keahlian_id" class="form-label">Program Keahlian</label>
            <select name="program_keahlian_id" class="form-select" required>
                <option value="">-- Pilih Program Keahlian --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_konsentrasi" class="form-label">Nama Konsentrasi</label>
            <input type="text" name="nama_konsentrasi" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.konsentrasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
