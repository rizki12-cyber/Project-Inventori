@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Card Selamat Datang Tanpa Background Putih -->
<div class="text-center mb-5 p-4 rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <h2 class="fw-bold mb-2">Selamat Datang, Admin! 👋</h2>
    <p class="fs-6 mb-0 opacity-90">Sistem Inventaris SMKN 1 TALAGA - Kelola barang dengan mudah dan efisien</p>
</div>


    <!-- Stat Cards Horizontal -->
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
                     style="background: linear-gradient(135deg, {{ $f['color'] }}15, {{ $f['color'] }}08); border-left: 4px solid {{ $f['color'] }}; min-height: 120px;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between h-100">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-2 fw-semibold small">{{ $f['title'] }}</h6>
                            <p class="card-text mb-0 fw-bold fs-3" id="{{ $f['id'] }}" style="color: {{ $f['color'] }};">{{ $f['count'] }}</p>
                        </div>
                        <div class="icon-container-horizontal rounded-4 p-3 ms-3" style="background: {{ $f['color'] }}20;">
                            <i class="{{ $f['icon'] }} fs-2" style="color: {{ $f['color'] }};"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Grafik Ringkasan -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-transparent border-0 py-4">
                    <h4 class="mb-0 fw-semibold text-primary">📊 Grafik Ringkasan Inventaris</h4>
                </div>
                <div class="card-body p-4">
                    <div style="height: 350px;">
                        <canvas id="dashboardChart" height="350"></canvas>
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

    // Update stat cards dengan animasi
    Object.keys(featureData).forEach(id => {
        const el = document.getElementById(id);
        if(el) {
            let count = 0;
            const target = featureData[id];
            const duration = 1500;
            const increment = target / (duration / 16);
            
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
                borderColor: [
                    '#2563eb', '#059669', '#d97706', '#0891b2', '#dc2626'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush

<style>
.stat-card-horizontal {
    transition: all 0.3s ease;
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card-horizontal:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15) !important;
}

.icon-container-horizontal {
    transition: all 0.3s ease;
}

.stat-card-horizontal:hover .icon-container-horizontal {
    transform: scale(1.1);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.fs-3 {
    font-size: 1.8rem !important;
    font-weight: 700;
}

@media (max-width: 768px) {
    .stat-card-horizontal {
        min-height: 100px !important;
    }
    
    .fs-3 {
        font-size: 1.5rem !important;
    }
    
    .card-body.p-5 {
        padding: 2rem !important;
    }
    
    .icon-container-horizontal {
        padding: 0.75rem !important;
    }
    
    .icon-container-horizontal i {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .stat-card-horizontal {
        min-height: 90px !important;
    }
    
    .fs-3 {
        font-size: 1.3rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}
</style>
@endsection