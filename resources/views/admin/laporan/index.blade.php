@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid mt-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1 text-primary"><i class="fas fa-chart-bar me-2"></i>Laporan Data</h3>
            <p class="text-muted mb-0">Kelola dan ekspor seluruh laporan inventaris</p>
        </div>
        <div class="d-flex gap-2 flex-wrap mt-2 mt-md-0">
            <a href="{{ route('admin.laporan.export.excel', array_merge(['jenis' => $jenis], request()->query())) }}"
                class="btn btn-success shadow-sm d-flex align-items-center gap-1">
                <i class="fas fa-file-excel"></i> Export Excel
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

                <!-- Jenis Laporan -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jenis Laporan</label>
                    <select name="jenis" class="form-select shadow-sm">
                        <option value="barang" {{ request('jenis')=='barang' ? 'selected':'' }}>Data Barang</option>
                        <option value="supplier" {{ request('jenis')=='supplier' ? 'selected':'' }}>Supplier</option>
                        <option value="barang_masuk" {{ request('jenis')=='barang_masuk' ? 'selected':'' }}>Barang Masuk</option>
                        <option value="barang_keluar" {{ request('jenis')=='barang_keluar' ? 'selected':'' }}>Barang Keluar</option>
                        <option value="peminjaman" {{ request('jenis')=='peminjaman' ? 'selected':'' }}>Peminjaman</option>
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
                        <i class="fas fa-search"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-table me-2"></i>
                {{-- Judul Otomatis --}}
                @switch($jenis)
                    @case('supplier') Supplier @break
                    @case('barang_masuk') Barang Masuk @break
                    @case('barang_keluar') Barang Keluar @break
                    @case('peminjaman') Peminjaman @break
                    @default Data Barang
                @endswitch
            </h5>

            <div class="text-muted small">
                Menampilkan {{ $data->count() }} data
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                {{-- TABEL DINAMIS --}}
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">

                        {{-- HEADER TABEL --}}
                        @if($jenis == 'barang')
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Jurusan</th>
                            </tr>

                        @elseif($jenis == 'supplier')
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Tanggal Input</th>
                            </tr>

                        @elseif($jenis == 'barang_masuk')
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Supplier</th>
                                <th>Jumlah</th>
                                <th>Tanggal Masuk</th>
                            </tr>

                        @elseif($jenis == 'barang_keluar')
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Tanggal Keluar</th>
                            </tr>

                        @elseif($jenis == 'peminjaman')
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        @endif

                    </thead>

                    <tbody>

                        {{-- BARIS DATA DINAMIS --}}
                        @forelse($data as $d)

                            @if($jenis == 'barang')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->kode_barang }}</td>
                                    <td>{{ $d->nama_barang }}</td>
                                    <td>{{ $d->kategori }}</td>
                                    <td>{{ $d->jumlah }}</td>
                                    <td>{{ $d->kondisi }}</td>
                                    <td>{{ $d->lokasi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->tanggal_pembelian)->format('d/m/Y') }}</td>

                                    <td>{{ $d->user->konsentrasi->nama_konsentrasi ?? '-' }}</td>

                                </tr>

                            @elseif($jenis == 'supplier')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->nama_supplier }}</td>
                                    <td>{{ $d->telepon }}</td>
                                    <td>{{ $d->alamat }}</td>
                                    <td>{{ $d->created_at->format('d/m/Y') }}</td>
                                </tr>

                            @elseif($jenis == 'barang_masuk')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->barang->nama_barang }}</td>
                                    <td>{{ $d->supplier->nama_supplier }}</td>
                                    <td>{{ $d->jumlah }}</td>
                                    <td>{{ $d->tanggal_masuk }}</td>
                                </tr>

                            @elseif($jenis == 'barang_keluar')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->barang->nama_barang }}</td>
                                    <td>{{ $d->jumlah }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>{{ $d->tanggal_keluar }}</td>
                                </tr>

                            @elseif($jenis == 'peminjaman')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->nama_peminjam }}</td>
                                    <td>{{ $d->barang->nama_barang }}</td>
                                    <td>{{ $d->jumlah }}</td>
                                    <td>{{ $d->tanggal_pinjam }}</td>
                                    <td>{{ $d->tanggal_kembali }}</td>
                                    <td>{{ $d->status }}</td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Tidak ada data.
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
    body { font-family: 'Poppins', sans-serif; }

    .card { transition: all 0.3s ease-in-out; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); }

    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #6c757d;
        border-top: none;
    }
    .table td { vertical-align: middle; font-size: 0.875rem; }
    .table-hover tbody tr:hover { background-color: #f1f5ff; transition: all 0.2s ease-in-out; }

    .form-select, .form-control { border-radius: 10px; transition: 0.2s; }
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #4e73df;
    }
</style>
@endsection
