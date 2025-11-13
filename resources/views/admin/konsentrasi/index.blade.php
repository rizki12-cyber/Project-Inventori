@extends('layouts.admin')

@section('title', 'Data Konsentrasi Keahlian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Konsentrasi Keahlian</h3>

    <a href="{{ route('admin.konsentrasi.create') }}" class="btn btn-primary mb-3">+ Tambah Konsentrasi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Program Keahlian</th>
                <th>Nama Konsentrasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->programKeahlian->nama_program ?? '-' }}</td>
                <td>{{ $item->nama_konsentrasi }}</td>
                <td>
                    <a href="{{ route('admin.konsentrasi.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.konsentrasi.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
