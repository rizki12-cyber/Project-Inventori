@extends('layouts.kabeng')

@section('title', 'Dashboard Kabeng')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Selamat Datang, {{ Auth::user()->name }} 👋</h3>
    <p>Anda login sebagai <strong>Kabeng {{ strtoupper(Auth::user()->jurusan ?? '-') }}</strong>.</p>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Barang</h5>
                    <h3>{{ $totalBarang ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Barang Layak</h5>
                    <h3>{{ $barangLayak ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Barang Rusak</h5>
                    <h3>{{ $barangRusak ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
