@extends('layouts.admin')

@section('title', 'Tambah Konsentrasi Keahlian')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tambah Konsentrasi Keahlian</h3>
        <!--<a href="{{ route('admin.konsentrasi.index') }}" class="btn btn-secondary btn-sm">Kembali</a> !-->
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.konsentrasi.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="program_keahlian_id" class="form-label">Program Keahlian</label>
            <select name="program_keahlian_id" id="program_keahlian_id" class="form-select" required>
                <option value="">-- Pilih Program Keahlian --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ old('program_keahlian_id') == $program->id ? 'selected' : '' }}>
                        {{ $program->nama_program }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_konsentrasi" class="form-label">Nama Konsentrasi</label>
            <input type="text" id="nama_konsentrasi" name="nama_konsentrasi" class="form-control" value="{{ old('nama_konsentrasi') }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.konsentrasi.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
