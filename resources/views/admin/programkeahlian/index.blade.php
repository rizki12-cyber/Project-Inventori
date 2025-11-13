@extends('layouts.admin')

@section('title', 'Data Program Keahlian')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Program Keahlian</h2>
        <a href="{{ route('admin.programkeahlian.create') }}" class="btn btn-primary btn-sm">
            + Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Program Keahlian</th>
                <th style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $i => $program)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $program->nama_program }}</td>
                    <td>
                        <a href="{{ route('admin.programkeahlian.edit', $program->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.programkeahlian.destroy', $program->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
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
