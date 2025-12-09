@extends('layouts.wakasek')

@section('title', 'Profil Wakasek')

@section('content')

<style>
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.profile-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }

@keyframes fadeSlideIn { 
    to { opacity: 1; transform: translateY(0); } 
}

.page-title {
    font-weight: 700; 
    font-size: 1.8rem;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
}

.card-profile {
    border: none; 
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    padding: 2rem;
}

/* Lingkaran ikon profil */
.header-circle {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 1.5rem auto;
    color: white;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.header-circle i {
    font-size: 55px;
}

.label-text { 
    font-weight: 600; 
    margin-bottom: 6px; 
}

.value-box {
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}
</style>

<div class="container py-5 profile-container">

    <h2 class="page-title">
        <i class="bi bi-person-vcard-fill me-2"></i>Profil Wakasek
    </h2>

    <div class="card-profile">

        <!-- Bulat ikon profil -->
        <div class="header-circle">
            <i class="bi bi-person-fill"></i>
        </div>

        <div class="mb-3">
            <div class="label-text">Nama Lengkap</div>
            <div class="value-box">{{ $wakasek->name }}</div>
        </div>

        <div class="mb-3">
            <div class="label-text">Alamat Email</div>
            <div class="value-box">{{ $wakasek->email }}</div>
        </div>

    </div>
</div>

@endsection
