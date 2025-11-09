@extends('layouts.admin')

@section('title', 'Laporan Barang')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">📊 Laporan Data Barang</h3>
            <p class="text-muted">Kelola dan ekspor data barang inventaris</p>
        </div>
        <div class="d-flex">
            <a href="{{ route('admin.laporan.export.pdf', request()->query()) }}" class="btn btn-danger me-2">
                <i class="fas fa-file-pdf me-1"></i> PDF
            </a>
            <a href="{{ route('admin.laporan.export.excel', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Excel
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Data</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for ($t = 2020; $t <= date('Y'); $t++)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanList as $j)
                            <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ request('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $barang->count() }}</h4>
                            <p class="mb-0">Total Barang</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $barang->where('kondisi', 'Baik')->count() }}</h4>
                            <p class="mb-0">Kondisi Baik</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $barang->where('kondisi', 'Rusak')->count() }}</h4>
                            <p class="mb-0">Kondisi Rusak</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $barang->where('kondisi', 'Hilang')->count() }}</h4>
                            <p class="mb-0">Kondisi Hilang</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Data Barang</h5>
            <div class="text-muted small">
                Menampilkan {{ $barang->count() }} data barang
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $b->kode_barang }}</span></td>
                                <td>{{ $b->nama_barang }}</td>
                                <td><span class="badge bg-light text-dark">{{ $b->kategori }}</span></td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">{{ $b->jumlah }}</span>
                                </td>
                                <td>
                                    @if($b->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif($b->kondisi == 'Rusak')
                                        <span class="badge bg-warning">Rusak</span>
                                    @else
                                        <span class="badge bg-danger">Hilang</span>
                                    @endif
                                </td>
                                <td>{{ $b->lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d/m/Y') }}</td>
                                <td>{{ $b->user->jurusan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data barang yang sesuai dengan filter.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Menghapus bagian pagination yang menyebabkan error -->
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
    }
    .form-select, .form-control {
        border-radius: 8px;
    }
    .btn {
        border-radius: 8px;
    }
</style>
@endsection