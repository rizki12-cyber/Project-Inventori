@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f3f6fd, #e9efff);
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-container {
        animation: fadeIn 0.8s ease forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- STAT CARD --- */
    .stat-card {
        border: none;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }

    .stat-card .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #374151;
        margin-bottom: 10px;
    }

    .stat-card .card-text {
        font-size: 2.1rem;
        font-weight: 700;
        color: #111827;
    }

    .bg-primary {
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
        color: #fff;
    }
    .bg-success {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
    }
    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #fff;
    }
    .bg-danger {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #fff;
    }

    /* --- CHART CARD --- */
    #chartCard {
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        padding: 30px;
        margin-top: 35px;
    }

    #chartCard h4 {
        font-weight: 600;
        color: #1e3a8a;
        margin-bottom: 25px;
        text-align: center;
    }

    #chartWrapper {
        height: 370px;
        position: relative;
    }
</style>

<div class="dashboard-container container-fluid">
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card bg-primary p-3">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text">{{ $totalBarang ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card bg-success p-3">
                <div class="card-body">
                    <h5 class="card-title">Barang Baik</h5>
                    <p class="card-text">{{ $barangBaik ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card bg-warning p-3">
                <div class="card-body">
                    <h5 class="card-title">Barang Rusak</h5>
                    <p class="card-text">{{ $barangRusak ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card bg-danger p-3">
                <div class="card-body">
                    <h5 class="card-title">Barang Hilang</h5>
                    <p class="card-text">{{ $barangHilang ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div id="chartCard">
        <h4>Statistik Kondisi Barang</h4>
        <div id="chartWrapper">
            <canvas id="barangChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
        const ctx = document.getElementById('barangChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Barang Baik', 'Barang Rusak', 'Barang Hilang'],
                datasets: [{
                    label: 'Jumlah Barang',
                    data: [{{ $barangBaik ?? 0 }}, {{ $barangRusak ?? 0 }}, {{ $barangHilang ?? 0 }}],
                    backgroundColor: [
                        'rgba(34,197,94,0.9)',
                        'rgba(234,179,8,0.9)',
                        'rgba(239,68,68,0.9)'
                    ],
                    borderColor: [
                        'rgba(34,197,94,1)',
                        'rgba(234,179,8,1)',
                        'rgba(239,68,68,1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#374151',
                            font: { size: 13, weight: '600' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(209,213,219,0.3)' },
                        ticks: {
                            color: '#374151',
                            stepSize: 1,
                            font: { size: 12 }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e3a8a',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 10,
                        padding: 12,
                        displayColors: false
                    }
                }
            }
        });
    };
</script>
@endpush
