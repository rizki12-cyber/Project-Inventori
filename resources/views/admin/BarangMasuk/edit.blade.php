@extends('layouts.admin')

@section('title', 'Edit Barang Masuk')

@section('content')
<div class="container my-4">

    <h3 class="mb-4">Edit Barang Masuk</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.barangmasuk.update', $barangMasuk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Barang</label>
                        <select name="id_barang" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                            <option value="{{ $b->id }}" 
                                {{ $barangMasuk->id_barang == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_barang }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Supplier</label>
                        <select name="id_supplier" class="form-control" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $s)
                            <option value="{{ $s->id }}" 
                                {{ $barangMasuk->id_supplier == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_supplier }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control"
                            value="{{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1"
                            value="{{ $barangMasuk->jumlah }}" required>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Simpan Perubahan</button>
                <a href="{{ route('admin.barangmasuk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
