@extends('layouts.kabeng')

@section('title', 'Dashboard Kabeng')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8faff);
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-header {
        animation: fadeInDown 0.8s ease-in-out;
    }

    .stat-card {
        border: none;
        border-radius: 15px;
        background: white;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        animation: fadeInUp 0.8s ease forwards;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2.2rem;
        margin-bottom: 10px;
        color: #4f46e5;
        background: #eef2ff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-title {
        color: #6b7280;
        font-weight: 500;
        margin-top: 5px;
    }
</style>

<div class="container-fluid py-4">
    <div class="dashboard-header mb-4">
        <h3 class="fw-bold text-primary mb-1">
            Selamat Datang, {{ Auth::user()->name }} 👋
        </h3>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-value">{{ $totalBarang ?? 0 }}</div>
                    <div class="stat-title">Total Barang</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value text-success">{{ $barangLayak ?? 0 }}</div>
                    <div class="stat-title">Barang Layak</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value text-danger">{{ $barangRusak ?? 0 }}</div>
                    <div class="stat-title">Barang Rusak</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
