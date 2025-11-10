@extends('layouts.admin')
@section('title', 'Tambah User')

@section('content')
<div class="container mt-4">
    <h3>➕ Tambah User</h3>

    <form action="{{ route('admin.datauser.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="wakasek">Wakasek</option>
                <option value="kabeng">Kabeng</option>
            </select>
        </div>
        <div class="mb-3" id="jurusanField" style="display:none;">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select">
                <option value="">-- Pilih Jurusan --</option>
                <option value="TKR">TKR</option>
                <option value="TSM">TSM</option>
                <option value="PPLG">PPLG</option>
                <option value="TKJ">TKJ</option>
                <option value="AKL">AKL</option>
                <option value="BDP">BDP</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
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
