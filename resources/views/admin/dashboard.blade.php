@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Dashboard Header -->
    <div class="dashboard-header text-center mb-4 p-4 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #2563eb, #1e3a8a); color: white;">
        <h2 class="fw-bold">Selamat Datang di Dashboard Admin 🎯</h2>
        <p>Lihat ringkasan kondisi barang di sistem inventaris SMKN 1 TALAGA</p>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-4 g-3">
        @php
            $stats = [
                ['id'=>'totalBarang','title'=>'Total Barang','icon'=>'bi-box-seam','bg'=>'primary','count'=>0],
                ['id'=>'barangBaik','title'=>'Barang Baik','icon'=>'bi-check2-circle','bg'=>'success','count'=>0],
                ['id'=>'barangRusak','title'=>'Barang Rusak','icon'=>'bi-exclamation-triangle-fill','bg'=>'warning','count'=>0],
                ['id'=>'barangHilang','title'=>'Barang Hilang','icon'=>'bi-x-circle-fill','bg'=>'danger','count'=>0],
            ];
        @endphp

        @foreach($stats as $s)
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-{{ $s['bg'] }}">
                    <i class="{{ $s['icon'] }} icon-bg"></i>
                    <div class="card-body">
                        <h5 class="card-title">{{ $s['title'] }}</h5>
                        <p class="card-text" id="{{ $s['id'] }}">{{ $s['count'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="card shadow-sm rounded-4 p-4">
        <h4 class="text-center mb-4">📊 Statistik Kondisi Barang</h4>
        <div style="height: 400px; width:100%;">
            <canvas id="barangChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const statsData = {!! json_encode([
        'totalBarang' => $totalBarang ?? 0,
        'barangBaik'  => $barangBaik ?? 0,
        'barangRusak' => $barangRusak ?? 0,
        'barangHilang'=> $barangHilang ?? 0
    ]) !!};

    Object.keys(statsData).forEach(id => {
        const el = document.getElementById(id);
        if(el) el.textContent = statsData[id];
    });

    // Tunggu sedikit supaya canvas sudah ready
    setTimeout(() => {
        const ctx = document.getElementById('barangChart').getContext('2d');

        // Gradient colors
        const gradientBaik = ctx.createLinearGradient(0,0,0,400);
        gradientBaik.addColorStop(0, 'rgba(34,197,94,1)');
        gradientBaik.addColorStop(1, 'rgba(134,239,172,0.6)');

        const gradientRusak = ctx.createLinearGradient(0,0,0,400);
        gradientRusak.addColorStop(0, 'rgba(234,179,8,1)');
        gradientRusak.addColorStop(1, 'rgba(254,240,138,0.6)');

        const gradientHilang = ctx.createLinearGradient(0,0,0,400);
        gradientHilang.addColorStop(0, 'rgba(239,68,68,1)');
        gradientHilang.addColorStop(1, 'rgba(251,191,182,0.6)');

        // Register plugin
        Chart.register(ChartDataLabels);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Barang Baik','Barang Rusak','Barang Hilang'],
                datasets: [{
                    label: 'Jumlah Barang',
                    data: [statsData.barangBaik, statsData.barangRusak, statsData.barangHilang],
                    backgroundColor: [gradientBaik, gradientRusak, gradientHilang],
                    borderRadius: 12,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1500, easing: 'easeOutBounce' },
                scales: {
                    x: { 
                        grid: { display:false },
                        ticks:{ color:'#374151', font:{size:13, weight:'600'} } 
                    },
                    y: { 
                        beginAtZero:true,
                        grid:{ color:'rgba(209,213,219,0.3)' },
                        ticks:{ color:'#374151', font:{size:12} } 
                    }
                },
                plugins: {
                    legend:{ display:false },
                    tooltip:{
                        backgroundColor:'#1e3a8a',
                        titleColor:'#fff',
                        bodyColor:'#fff',
                        cornerRadius:10,
                        padding:12,
                        displayColors:false
                    },
                    datalabels: {
                        color:'#374151',
                        anchor:'end',
                        align:'end',
                        font:{ weight:'700', size:14 },
                        formatter: value => value
                    }
                }
            }
        });
    }, 50); // 50ms delay supaya canvas ready

});
</script>
@endpush


<style>
.dashboard-header { box-shadow: 0 8px 25px rgba(0,0,0,0.1); }

.stat-card {
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    text-align:center;
    padding: 25px 15px;
    position: relative;
    color: white;
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}
.stat-card .icon-bg {
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 5rem;
    opacity: 0.15;
    transform: rotate(20deg);
}
.stat-card .card-title { font-weight:600; margin-bottom:8px; }
.stat-card .card-text { font-size:2rem; font-weight:700; }

/* Responsive */
@media (max-width:768px){
    .stat-card .icon-bg{ font-size:4rem; top:-15px; right:-15px; }
    .stat-card .card-text{ font-size:1.6rem; }
}
</style>
@endsection
