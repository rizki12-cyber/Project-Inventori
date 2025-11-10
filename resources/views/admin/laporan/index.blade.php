@extends('layouts.admin')

@section('title', 'Laporan Barang')

@section('content')
<div class="container-fluid mt-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1 text-primary"><i class="fas fa-chart-bar me-2"></i>Laporan Data Barang</h3>
            <p class="text-muted mb-0">Kelola dan ekspor data barang inventaris</p>
        </div>
        <div class="d-flex gap-2 flex-wrap mt-2 mt-md-0">
            <a href="{{ route('admin.laporan.export.pdf', request()->query()) }}" class="btn btn-danger shadow-sm d-flex align-items-center gap-1">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('admin.laporan.export.excel', request()->query()) }}" class="btn btn-success shadow-sm d-flex align-items-center gap-1">
                <i class="fas fa-file-excel"></i> Excel
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="fas fa-filter me-2"></i>Filter Data</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select shadow-sm">
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
                    <select name="tahun" class="form-select shadow-sm">
                        <option value="">Semua Tahun</option>
                        @for ($t = 2020; $t <= date('Y'); $t++)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <select name="jurusan" class="form-select shadow-sm">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanList as $j)
                            <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select shadow-sm">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ request('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary shadow-sm d-flex align-items-center gap-1">
                        <i class="fas fa-search"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4 g-3">
        @php
            $summary = [
                ['title'=>'Total Barang','count'=>$barang->count(),'icon'=>'fa-box','bg'=>'primary'],
                ['title'=>'Kondisi Baik','count'=>$barang->where('kondisi','Baik')->count(),'icon'=>'fa-check-circle','bg'=>'success'],
                ['title'=>'Kondisi Rusak','count'=>$barang->where('kondisi','Rusak')->count(),'icon'=>'fa-exclamation-triangle','bg'=>'warning'],
                ['title'=>'Kondisi Hilang','count'=>$barang->where('kondisi','Hilang')->count(),'icon'=>'fa-times-circle','bg'=>'danger']
            ];
        @endphp

        @foreach($summary as $s)
            <div class="col-md-3">
                <div class="card shadow-sm h-100 rounded-3 border-0 text-white" style="background: linear-gradient(135deg, rgba(78,115,223,0.85), rgba(28,200,138,0.85));">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $s['count'] }}</h4>
                            <p class="mb-0">{{ $s['title'] }}</p>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas {{ $s['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary"><i class="fas fa-table me-2"></i>Data Barang</h5>
            <div class="text-muted small">
                Menampilkan {{ $barang->count() }} data barang
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
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
                                <td><span class="badge bg-primary rounded-pill">{{ $b->jumlah }}</span></td>
                                <td>
                                    @php
                                        $kondisiColors = ['Baik'=>'success','Rusak'=>'warning text-dark','Hilang'=>'danger'];
                                    @endphp
                                    <span class="badge bg-{{ $kondisiColors[$b->kondisi] ?? 'secondary' }}">{{ $b->kondisi }}</span>
                                </td>
                                <td>{{ $b->lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d/m/Y') }}</td>
                                <td>{{ $b->user->jurusan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                    Tidak ada data barang yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    /* Card hover */
    .card {
        transition: all 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }

    /* Table styling */
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #6c757d;
        border-top: none;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f5ff;
        transform: scale(1.002);
        transition: all 0.2s ease-in-out;
    }

    /* Form styling */
    .form-select, .form-control {
        border-radius: 10px;
        transition: all 0.2s;
    }
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #4e73df;
    }

    /* Button styling */
    .btn {
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .card-body form .col-md-3.d-flex {
            justify-content: flex-start;
        }
    }
</style>
@endsection
