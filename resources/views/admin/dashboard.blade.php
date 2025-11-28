@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Header Welcome -->
    <div class="text-center mb-5 p-4 rounded-4"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h2 class="fw-bold mb-2">Selamat Datang, Admin! 👋</h2>
        <p class="fs-6 mb-0 opacity-90">Sistem Inventaris SMKN 1 TALAGA - Kelola barang dengan mudah dan efisien</p>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-4 g-3">
        @php
            $features = [
                ['id'=>'totalBarang', 'title'=>'Total Barang', 'icon'=>'bi-box-seam', 'color'=>'#3b82f6', 'count'=>0],
                ['id'=>'totalBarangMasuk', 'title'=>'Barang Masuk', 'icon'=>'bi-box-arrow-in-down', 'color'=>'#10b981', 'count'=>0],
                ['id'=>'totalBarangKeluar', 'title'=>'Barang Keluar', 'icon'=>'bi-box-arrow-up', 'color'=>'#f59e0b', 'count'=>0],
                ['id'=>'totalSupplier', 'title'=>'Supplier', 'icon'=>'bi-people-fill', 'color'=>'#06b6d4', 'count'=>0],
                ['id'=>'totalPeminjaman', 'title'=>'Peminjaman', 'icon'=>'bi-clipboard-check', 'color'=>'#ef4444', 'count'=>0],
            ];
        @endphp

        @foreach($features as $f)
            <div class="col-12 col-sm-6 col-lg">
                <div class="stat-card-horizontal position-relative overflow-hidden rounded-4 shadow-sm"
                    style="background: linear-gradient(135deg, {{ $f['color'] }}15, {{ $f['color'] }}08);
                           border-left: 4px solid {{ $f['color'] }}; min-height: 120px;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between h-100">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-2 fw-semibold small">{{ $f['title'] }}</h6>
                            <p class="card-text mb-0 fw-bold fs-3" id="{{ $f['id'] }}"
                                style="color: {{ $f['color'] }};">{{ $f['count'] }}</p>
                        </div>
                        <div class="icon-container-horizontal rounded-4 p-3 ms-3" style="background: {{ $f['color'] }}20;">
                            <i class="{{ $f['icon'] }} fs-2" style="color: {{ $f['color'] }};"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Grafik Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-transparent border-0 py-4">
                    <h4 class="mb-0 fw-semibold text-primary">📊 Grafik Ringkasan Inventaris</h4>
                </div>
                <div class="card-body p-4">
                    <div style="height: 350px;">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const featureData = {!! json_encode([
        'totalBarang' => $totalBarang ?? 0,
        'totalBarangMasuk' => $totalBarangMasuk ?? 0,
        'totalBarangKeluar'=> $totalBarangKeluar ?? 0,
        'totalSupplier'    => $totalSupplier ?? 0,
        'totalPeminjaman'  => $totalPeminjaman ?? 0,
    ]) !!};

    // Animasi Angka
    Object.keys(featureData).forEach(id => {
        const el = document.getElementById(id);
        if(el) {
            let count = 0;
            const target = featureData[id];
            const increment = target / 90;
            
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    count = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(count).toLocaleString();
            }, 16);
        }
    });

    // Chart.js
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Barang', 'Barang Masuk', 'Barang Keluar', 'Supplier', 'Peminjaman'],
            datasets: [{
                label: 'Jumlah Data',
                data: [
                    featureData.totalBarang,
                    featureData.totalBarangMasuk,
                    featureData.totalBarangKeluar,
                    featureData.totalSupplier,
                    featureData.totalPeminjaman
                ],
                backgroundColor: [
                    '#3b82f6', '#10b981', '#f59e0b', '#06b6d4', '#ef4444'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush

<style>
/* ====== Card & UI Styling ====== */

.stat-card-horizontal {
    transition: 0.3s ease;
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card-horizontal:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15) !important;
}

.icon-container-horizontal { transition: 0.3s ease; }

.stat-card-horizontal:hover .icon-container-horizontal {
    transform: scale(1.1);
}

/* Responsive font */
.fs-3 {
    font-size: clamp(1.2rem, 2.5vw, 1.8rem) !important;
    font-weight: 700;
}

/* ===== Tablet ===== */
@media (max-width: 992px) {
    .stat-card-horizontal { min-height: 110px !important; }
}

/* ===== HP Medium ===== */
@media (max-width: 768px) {
    .row.g-3 > div { flex: 0 0 50%; max-width: 50%; }
    .stat-card-horizontal { min-height: 95px !important; }
}

/* ===== HP Kecil ===== */
@media (max-width: 576px) {
    .row.g-3 > div { flex: 0 0 100%; max-width: 100%; }
    .stat-card-horizontal { min-height: 85px !important; }

    /* Disable hover di HP */
    .stat-card-horizontal:hover {
        transform: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
