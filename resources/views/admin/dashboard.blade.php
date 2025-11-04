@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    body {
        background: #f8f9fa;
    }

    /* Animasi untuk container dashboard */
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

    .stat-card {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: default;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .stat-card .card-title {
        font-weight: 600;
        font-size: 1.1rem;
    }
    .stat-card .card-text {
        font-size: 2rem;
        font-weight: bold;
    }

    #chartCard {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 20px;
        background: #fff;
        margin-top: 30px;
    }
</style>

<div class="dashboard-container">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary stat-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text count">{{ $totalBarang ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success stat-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Barang Baik</h5>
                    <p class="card-text count">{{ $barangBaik ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning stat-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Barang Rusak</h5>
                    <p class="card-text count">{{ $barangRusak ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger stat-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Barang Hilang</h5>
                    <p class="card-text count">{{ $barangHilang ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="chartCard">
        <canvas id="barangChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart dengan animasi slide-up
    const ctx = document.getElementById('barangChart').getContext('2d');
    const barangChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Baik', 'Rusak', 'Hilang'],
            datasets: [{
                label: 'Jumlah Barang',
                data: [{{ $barangBaik ?? 0 }}, {{ $barangRusak ?? 0 }}, {{ $barangHilang ?? 0 }}],
                backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                borderRadius: 10,
                barPercentage: 0.6,
                categoryPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
