@extends('layouts.kabeng')

@section('title', 'Dashboard Kabeng')

@section('content')
<div class="container-fluid">

    <!-- Header Welcome -->
    <div class="text-center mb-5 p-4 rounded-4"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h2 class="fw-bold mb-2">Selamat Datang, Kabeng! 👋</h2>
        <p class="fs-6 mb-0 opacity-90">Sistem Inventaris SMKN 1 TALAGA - Ringkasan data inventaris</p>
    </div>

    <!-- Card Total Barang -->
    <div class="row mb-4 g-3">
        <div class="col-12">
            <div class="stat-card-horizontal position-relative overflow-hidden rounded-4 shadow-sm"
                style="background: linear-gradient(135deg, #3b82f615, #3b82f608);
                       border-left: 4px solid #3b82f6; min-height: 120px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between h-100">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-2 fw-semibold small">Total Barang</h6>
                        <p class="card-text mb-0 fw-bold fs-3" id="totalBarang"
                           style="color: #3b82f6;">{{ $totalBarang }}</p>
                    </div>
                    <div class="icon-container-horizontal rounded-4 p-3 ms-3" style="background: #3b82f620;">
                        <i class="bi bi-box-seam fs-2" style="color: #3b82f6;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card shadow-sm rounded-4 p-4 mt-4">
        <h5 class="fw-bold mb-3">Grafik Barang Berdasarkan Kategori</h5>
        <div style="height: 300px;">
            <canvas id="kabengChart"></canvas>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const totalBarang = {{ $totalBarang ?? 0 }};

    // Animasi angka
    let el = document.getElementById('totalBarang');
    let start = 0;
    let end = totalBarang;
    let duration = 800;
    let stepTime = 10;
    let increment = (end - start) / (duration / stepTime);

    let timer = setInterval(() => {
        start += increment;
        if (start >= end) {
            start = end;
            clearInterval(timer);
        }
        el.textContent = Math.floor(start).toLocaleString();
    }, stepTime);

    // Grafik kategori
    const ctx = document.getElementById('kabengChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($kategoriLabels) !!},
                datasets: [{
                    label: 'Jumlah Barang',
                    data: {!! json_encode($kategoriData) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }},
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
    }

});
</script>

@endsection

<style>
.stat-card-horizontal {
    transition: 0.3s ease;
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
}
.stat-card-horizontal:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15) !important;
}
.icon-container-horizontal {
    transition: 0.3s ease;
}
.stat-card-horizontal:hover .icon-container-horizontal {
    transform: scale(1.1);
}
</style>
