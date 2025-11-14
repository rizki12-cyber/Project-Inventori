@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid py-5 admin-profile-container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <!-- Profile Card -->
            <div class="profile-card animate-slide-up">
                <!-- Header dengan Background Biru -->
                <div class="profile-header">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                    <div class="profile-info-header">
                        <h3 class="profile-title">Profil Administrator</h3>
                        <p class="profile-subtitle">Kelola informasi akun Anda</p>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="profile-content">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert-success-box animate-bounce-in">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.profile.update') }}" method="POST" class="profile-form">
                        @csrf
                        
                        <!-- Informasi Pribadi Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-user-circle me-2"></i>
                                <span>Informasi Pribadi</span>
                            </div>
                            
                            <!-- Name Field -->
                            <div class="form-group floating-group">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" class="floating-input @error('name') error @enderror" 
                                       id="name" name="name" value="{{ old('name', $admin->name) }}" 
                                       placeholder=" " required>
                                <label class="floating-label">Nama Lengkap</label>
                                @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group floating-group">
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" class="floating-input @error('email') error @enderror" 
                                       id="email" name="email" value="{{ old('email', $admin->email) }}" 
                                       placeholder=" " required>
                                <label class="floating-label">Alamat Email</label>
                                @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keamanan Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-shield-alt me-2"></i>
                                <span>Keamanan Akun</span>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group floating-group">
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" class="floating-input @error('password') error @enderror" 
                                       id="password" name="password" placeholder=" ">
                                <label class="floating-label">Kata Sandi Baru (opsional)</label>
                                <button type="button" class="password-toggle" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group floating-group">
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" class="floating-input" 
                                       id="password_confirmation" name="password_confirmation" placeholder=" ">
                                <label class="floating-label">Konfirmasi Kata Sandi</label>
                                <button type="button" class="password-toggle" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-submit">
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Perbarui Profil</span>
                                <span class="btn-icon">
                                    <i class="fas fa-save"></i>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Footer Info -->
                    <div class="profile-footer">
                        <div class="last-update">
                            <i class="fas fa-clock me-2"></i>
                            Terakhir diperbarui: {{ $admin->updated_at->format('d M Y, H:i') }}
                        </div>
                        <div class="account-info">
                            <i class="fas fa-user-tag me-2"></i>
                            Status: Administrator
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    .admin-profile-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        min-height: 100vh;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(32, 94, 171, 0.1);
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    /* Header Styles */
    .profile-header {
        background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
        padding: 30px 30px 80px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: white;
    }

    .profile-avatar {
        margin-bottom: 20px;
    }

    .avatar-circle {
        width: 110px;
        height: 110px;
        background: linear-gradient(135deg, #64b5f6 0%, #1976d2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border: 4px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
    }

    .avatar-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .avatar-circle i {
        font-size: 2.8rem;
        color: white;
    }

    .profile-info-header {
        z-index: 2;
    }

    .profile-title {
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 1.8rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Content Styles */
    .profile-content {
        padding: 40px 35px 30px;
        margin-top: -60px;
        position: relative;
        z-index: 3;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2.5rem;
        padding: 25px;
        background: #f8fbff;
        border-radius: 16px;
        border: 1px solid #e3f2fd;
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.05);
    }

    .section-title {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 12px;
        border-bottom: 2px solid #e3f2fd;
        color: #1565c0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .section-title i {
        font-size: 1.2rem;
    }

    /* Form Styles */
    .profile-form {
        margin-top: 1rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 1.8rem;
    }

    .floating-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64b5f6;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .floating-input {
        width: 100%;
        padding: 16px 16px 16px 48px;
        border: 2px solid #e3f2fd;
        border-radius: 12px;
        background: #ffffff;
        font-size: 1rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        color: #37474f;
    }

    .floating-input:focus {
        border-color: #1e88e5;
        box-shadow: 0 0 0 4px rgba(30, 136, 229, 0.15);
        padding-left: 52px;
    }

    .floating-input:focus + .floating-label,
    .floating-input:not(:placeholder-shown) + .floating-label {
        top: -10px;
        left: 44px;
        font-size: 0.8rem;
        color: #1e88e5;
        background: #ffffff;
        padding: 0 8px;
        z-index: 3;
        font-weight: 500;
    }

    .floating-label {
        position: absolute;
        top: 50%;
        left: 48px;
        transform: translateY(-50%);
        color: #90a4ae;
        font-size: 1rem;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 2;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #90a4ae;
        cursor: pointer;
        z-index: 2;
        transition: color 0.3s ease;
        padding: 5px;
        border-radius: 4px;
    }

    .password-toggle:hover {
        color: #1e88e5;
        background: rgba(30, 136, 229, 0.1);
    }

    /* Submit Button */
    .form-submit {
        text-align: center;
        margin-top: 2.5rem;
    }

    .submit-btn {
        background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
        border: none;
        border-radius: 12px;
        padding: 16px 45px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(30, 136, 229, 0.3);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(30, 136, 229, 0.4);
        gap: 15px;
    }

    .btn-icon {
        transition: transform 0.3s ease;
    }

    .submit-btn:hover .btn-icon {
        transform: scale(1.1);
    }

    /* Alert Styles */
    .alert-success-box {
        background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.2);
        border-left: 4px solid #81c784;
    }

    .error-message {
        color: #e53935;
        font-size: 0.85rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: #ffebee;
        border-radius: 6px;
        border-left: 3px solid #e53935;
    }

    .floating-input.error {
        border-color: #e53935;
        background: #fff5f5;
    }

    /* Footer Styles */
    .profile-footer {
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e3f2fd;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .last-update, .account-info {
        color: #78909c;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    /* Animations */
    .animate-slide-up {
        animation: slideUp 0.8s ease-out forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    .animate-bounce-in {
        animation: bounceIn 0.6s ease-out forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-content {
            padding: 40px 20px 25px;
        }
        
        .profile-header {
            padding: 25px 25px 70px;
        }
        
        .avatar-circle {
            width: 90px;
            height: 90px;
        }
        
        .avatar-circle i {
            font-size: 2.2rem;
        }
        
        .profile-title {
            font-size: 1.5rem;
        }
        
        .form-section {
            padding: 20px;
        }
        
        .profile-footer {
            flex-direction: column;
            gap: 10px;
        }
    }

    @media (max-width: 576px) {
        .profile-header {
            padding: 20px 20px 60px;
        }
        
        .profile-content {
            margin-top: -50px;
        }
        
        .avatar-circle {
            width: 80px;
            height: 80px;
        }
        
        .avatar-circle i {
            font-size: 1.8rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const toggleButtons = document.querySelectorAll('.password-toggle');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Form submission animation
        const form = document.querySelector('.profile-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.submit-btn');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnIcon = submitBtn.querySelector('.btn-icon');
                
                btnText.textContent = 'Memperbarui...';
                btnIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
            });
        }

        // Add focus effects
        const inputs = document.querySelectorAll('.floating-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
</script>
@endsection