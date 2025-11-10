@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <h3>✏️ Edit User</h3>

    <form action="{{ route('admin.datauser.update', $user->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="wakasek" {{ $user->role == 'wakasek' ? 'selected' : '' }}>Wakasek</option>
                <option value="kabeng" {{ $user->role == 'kabeng' ? 'selected' : '' }}>Kabeng</option>
            </select>
        </div>
        <div class="mb-3" id="jurusanField" style="{{ $user->role == 'kabeng' ? '' : 'display:none;' }}">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select">
                <option value="">-- Pilih Jurusan --</option>
                @foreach(['TKR','TSM','PPLG','TKJ','AKL','BDP'] as $jur)
                    <option value="{{ $jur }}" {{ $user->jurusan == $jur ? 'selected' : '' }}>{{ $jur }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.datauser.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        document.getElementById('jurusanField').style.display = 
            this.value === 'kabeng' ? 'block' : 'none';
    });
</script>
@endsection
