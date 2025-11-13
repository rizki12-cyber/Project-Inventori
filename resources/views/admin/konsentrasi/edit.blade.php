@extends('layouts.admin')

@section('title', 'Edit Konsentrasi Keahlian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Edit Konsentrasi Keahlian</h3>

    <form action="{{ route('admin.konsentrasi.update', $konsentrasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="program_keahlian_id" class="form-label">Program Keahlian</label>
            <select name="program_keahlian_id" class="form-select" required>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ $konsentrasi->program_keahlian_id == $program->id ? 'selected' : '' }}>
                        {{ $program->nama_program }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_konsentrasi" class="form-label">Nama Konsentrasi</label>
            <input type="text" name="nama_konsentrasi" class="form-control" value="{{ $konsentrasi->nama_konsentrasi }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.konsentrasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
