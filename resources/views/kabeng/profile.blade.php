@extends('layouts.kabeng')

@section('title', 'Profil Kabeng')

@section('content')
<style>
    /* --- PROFILE PAGE STYLE --- */

    .profile-card {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border-radius: 20px;
        background: white;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-header img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #3b82f6;
    }

    .info-box {
        background: #f8fafc;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        border-left: 5px solid #2563eb;
    }

    .info-box label {
        font-weight: 600;
        margin-bottom: 3px;
        display: block;
        color: #475569;
    }

    .info-box p {
        margin: 0;
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }
</style>

<div class="container mt-4">
    <div class="profile-card">

        {{-- PROFILE HEADER --}}
        <div class="profile-header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($kabeng->name) }}&background=3b82f6&color=fff&size=128" alt="Avatar">

            <h3 class="mt-3 fw-bold">{{ $kabeng->name }}</h3>
            <p class="text-muted">{{ $kabeng->email }}</p>
        </div>

        {{-- PROFILE INFO READ ONLY --}}
        <div class="info-box">
            <label>Nama Lengkap</label>
            <p>{{ $kabeng->name }}</p>
        </div>

        <div class="info-box">
            <label>Email</label>
            <p>{{ $kabeng->email }}</p>
        </div>

        <div class="info-box">
            <label>Role</label>
            <p>Kabeng</p>
        </div>
    </div>
</div>

@endsection
