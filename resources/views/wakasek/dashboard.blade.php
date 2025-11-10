@extends('layouts.wakasek')

@section('title', 'Dashboard Wakasek')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f3f6fd, #e9efff);
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
    }

    .dashboard-container {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeSlideIn 0.8s forwards;
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stat Cards */
    .stat-card {
        border-radius: 20px;
        padding: 25px 20px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        color: #fff;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .stat-card .card-title {
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .stat-card .card-text {
        font-size: 2.2rem;
        font-weight: 700;
    }

    .stat-card .icon-bg {
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 5rem;
        opacity: 0.15;
        transform: rotate(15deg);
    }

    .bg-primary { background: linear-gradient(135deg, #2563eb, #1e40af); }
    .bg-success { background: linear-gradient(135deg, #10b981, #047857); }
    .bg-warning { background: linear-gradient(135deg, #facc15, #ca8a04); }
    .bg-danger { background: linear-gradient(135deg, #ef4444, #991b1b); }

    /* Chart Card */
    #chartCard {
        border-radius: 20px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.06);
        padding: 30px;
        background: #fff;
        margin-top: 40px;
    }

    #chartCard canvas {
        width: 100% !important;
        max-height: 250px;
    }

    @media (max-width: 768px) {
        .stat-card .card-text {
            font-size: 1.8rem;
        }
        #chartCard {
            padding: 20px;
        }
    }
</style>

<div class="dashboard-container container-fluid">
    <div class="row g-3">
        <!-- Total Barang -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card bg-primary">
                <i class="bi bi-box-seam icon-bg"></i>
                <div class="text-center">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text">{{ $totalBarang ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Barang Baik -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card bg-success">
                <i class="bi bi-check2-circle icon-bg"></i>
                <div class="text-center">
                    <h5 class="card-title">Barang Baik</h5>
                    <p class="card-text">{{ $barangBaik ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Barang Rusak -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card bg-warning">
                <i class="bi bi-exclamation-triangle-fill icon-bg"></i>
                <div class="text-center">
                    <h5 class="card-title">Barang Rusak</h5>
                    <p class="card-text">{{ $barangRusak ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Barang Hilang -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card bg-danger">
                <i class="bi bi-x-circle-fill icon-bg"></i>
                <div class="text-center">
                    <h5 class="card-title">Barang Hilang</h5>
                    <p class="card-text">{{ $barangHilang ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div id="chartCard">
        <canvas id="barangChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('barangChart').getContext('2d');

    // Gradient bars
    const gradientBaik = ctx.createLinearGradient(0,0,0,300);
    gradientBaik.addColorStop(0, '#34d399');
    gradientBaik.addColorStop(1, '#d1fae5');

    const gradientRusak = ctx.createLinearGradient(0,0,0,300);
    gradientRusak.addColorStop(0, '#facc15');
    gradientRusak.addColorStop(1, '#fef3c7');

    const gradientHilang = ctx.createLinearGradient(0,0,0,300);
    gradientHilang.addColorStop(0, '#ef4444');
    gradientHilang.addColorStop(1, '#fee2e2');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Barang Baik', 'Barang Rusak', 'Barang Hilang'],
            datasets: [{
                label: 'Jumlah Barang',
                data: [{{ $barangBaik ?? 0 }}, {{ $barangRusak ?? 0 }}, {{ $barangHilang ?? 0 }}],
                backgroundColor: [gradientBaik, gradientRusak, gradientHilang],
                borderRadius: 12,
                barPercentage: 0.6,
                categoryPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor:'#1e3a8a',
                    titleColor:'#fff',
                    bodyColor:'#fff',
                    cornerRadius:8,
                    padding:10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color:'#374151' },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { color:'#374151' },
                    grid: { display:false }
                }
            }
        }
    });
});
</script>
@endsection
