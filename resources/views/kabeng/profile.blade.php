@extends('layouts.kabeng')

@section('title', 'Profil Kabeng')

@section('content')

<style>
body { font-family: 'Poppins', sans-serif; color: #1e293b; }
.profile-container { animation: fadeSlideIn 0.7s ease forwards; opacity: 0; transform: translateY(20px); }

@keyframes fadeSlideIn { 
    to { opacity: 1; transform: translateY(0); } 
}

/* Judul tetap BIRU */
.page-title {
    font-weight: 700; 
    font-size: 1.8rem;
    background: linear-gradient(90deg, #2563eb, #1e40af); /* BIRU */
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

/* Bulat ikon profil - HIJAU */
.header-circle {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #16a34a, #065f46); /* Warna hijau */
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 1.5rem auto;
    color: white;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.header-circle img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
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
        <i class="bi bi-person-vcard-fill me-2"></i>Profil Kabeng
    </h2>

    <div class="card-profile">

        <!-- Avatar kabeng -->
        <div class="header-circle">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($kabeng->name) }}&background=16a34a&color=fff&size=128" alt="avatar">
        </div>

        <div class="mb-3">
            <div class="label-text">Nama Lengkap</div>
            <div class="value-box">{{ $kabeng->name }}</div>
        </div>

        <div class="mb-3">
            <div class="label-text">Alamat Email</div>
            <div class="value-box">{{ $kabeng->email }}</div>
        </div>

        <div>
            <div class="label-text">Role</div>
            <div class="value-box">Kabeng</div>
        </div>

    </div>
</div>

@endsection
