@extends('layouts.admin')

@section('title', 'Data Program Keahlian')

@section('content')
<div class="container mt-4">
    <h2>Data Program Keahlian</h2>
    <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-primary mb-3">+ Tambah Program</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Program Keahlian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $i => $program)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $program->nama_program }}</td>
                    <td>
                        <a href="{{ route('admin.programkeahlian.edit', $program->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.programkeahlian.destroy', $program->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data program keahlian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
