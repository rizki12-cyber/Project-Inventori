@extends('layouts.wakasek')

@section('title', 'Laporan Barang')

@section('content')
<div class="container-fluid mt-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1 text-primary">
                <i class="bi bi-box-seam-fill me-2"></i>
                Laporan Barang Wakasek
            </h3>
            <p class="text-muted mb-0">Kelola dan ekspor laporan barang jurusan Anda</p>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-2 mt-md-0">
            @if($jenis)
            <a href="{{ route('wakasek.laporan.export.excel', array_merge(['jenis' => $jenis], request()->query())) }}"
                class="btn btn-success shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
            </a>
            @endif
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">
                <i class="bi bi-funnel-fill me-2"></i>Filter Data
            </h5>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('wakasek.laporan.index') }}" class="row g-3 align-items-end">

                <!-- Jenis Laporan -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jenis Laporan</label>
                    <select name="jenis" class="form-select shadow-sm">
                        <option value="" {{ !$jenis ? 'selected' : '' }}>-- Pilih Jenis Laporan --</option>
                        <option value="barang" {{ $jenis=='barang' ? 'selected':'' }}>Data Barang Aktif</option>
                        <option value="barang_dihapus" {{ $jenis=='barang_dihapus' ? 'selected':'' }}>Data Barang Dihapus</option>
                    </select>
                </div>

                <!-- Bulan -->
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

                <!-- Tahun -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select shadow-sm">
                        <option value="">Semua Tahun</option>
                        @for ($t = 2020; $t <= date('Y'); $t++)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-md-3 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary shadow-sm d-flex align-items-center gap-1">
                        <i class="bi bi-search"></i> Terapkan
                    </button>
                    <a href="{{ route('wakasek.laporan.index') }}"
                       class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    @if($jenis)
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary">
                <i class="bi bi-table me-2"></i>

                @if($jenis == 'barang')
                    Data Barang Aktif
                @else
                    Data Barang Dihapus
                @endif
            </h5>

            <div class="text-muted small">
                Menampilkan {{ $data->count() }} data
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pembelian</th>
                            @if($jenis == 'barang_dihapus')
                                <th>Tanggal Penghapusan</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->jumlah }}</td>
                            <td>{{ $b->kondisi }}</td>
                            <td>{{ $b->lokasi }}</td>
                            <td>{{ $b->keterangan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_pembelian)->format('d/m/Y') }}</td>

                            @if($jenis == 'barang_dihapus')
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_penghapusan)->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox-fill fa-2x mb-2"></i><br>
                                Silahkan pilih jenis laporan dan klik "Terapkan" untuk melihat data.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    body { font-family: 'Poppins', sans-serif; }
    .card { transition: all 0.3s ease-in-out; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); }
    .table-hover tbody tr:hover { background-color: #f1f5ff; transition: all 0.2s ease; }
    .form-select { border-radius: 10px; }
</style>
@endsection
