@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <!-- Profile Card -->
            <div class="profile-card animate-slide-up">
                <!-- Header dengan Background Gradient -->
                <div class="profile-header">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="fas fa-user-cog"></i>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="profile-content">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 class="profile-title">Profil Admin</h3>
                        <p class="profile-subtitle">Kelola informasi akun Anda</p>
                    </div>

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

                        <!-- Password Section Title -->
                        <div class="section-divider">
                            <span class="divider-text">Ubah Password</span>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group floating-group">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" class="floating-input @error('password') error @enderror" 
                                   id="password" name="password" placeholder=" ">
                            <label class="floating-label">Password Baru (opsional)</label>
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
                            <label class="floating-label">Konfirmasi Password</label>
                            <button type="button" class="password-toggle" data-target="password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-submit">
                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Update Profil</span>
                                <span class="btn-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Footer Info -->
                    <div class="profile-footer">
                        <div class="last-update">
                            <i class="fas fa-clock me-2"></i>
                            Terakhir update: {{ $admin->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    .profile-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        position: relative;
    }

    /* Header Styles */
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 140px;
        position: relative;
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }

    .profile-avatar {
        position: absolute;
        bottom: -50px;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        border: 4px solid #ffffff;
        transition: all 0.4s ease;
    }

    .avatar-circle:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .avatar-circle i {
        font-size: 2.5rem;
        color: white;
    }

    /* Content Styles */
    .profile-content {
        padding: 70px 40px 30px;
    }

    .profile-title {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 1.75rem;
    }

    .profile-subtitle {
        color: #718096;
        font-size: 0.95rem;
    }

    /* Form Styles */
    .profile-form {
        margin-top: 2rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 2rem;
    }

    .floating-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .floating-input {
        width: 100%;
        padding: 16px 16px 16px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        font-size: 1rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .floating-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        padding-left: 52px;
    }

    .floating-input:focus + .floating-label,
    .floating-input:not(:placeholder-shown) + .floating-label {
        top: -10px;
        left: 44px;
        font-size: 0.8rem;
        color: #667eea;
        background: #ffffff;
        padding: 0 8px;
        z-index: 3;
    }

    .floating-label {
        position: absolute;
        top: 50%;
        left: 48px;
        transform: translateY(-50%);
        color: #a0aec0;
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
        color: #a0aec0;
        cursor: pointer;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    /* Section Divider */
    .section-divider {
        text-align: center;
        margin: 2.5rem 0 1.5rem;
        position: relative;
    }

    .section-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }

    .divider-text {
        background: #ffffff;
        padding: 0 1.5rem;
        color: #718096;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Submit Button */
    .form-submit {
        text-align: center;
        margin-top: 3rem;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 16px;
        padding: 16px 40px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        gap: 16px;
    }

    .btn-icon {
        transition: transform 0.3s ease;
    }

    .submit-btn:hover .btn-icon {
        transform: translateX(4px);
    }

    /* Alert Styles */
    .alert-success-box {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
    }

    .floating-input.error {
        border-color: #e53e3e;
    }

    /* Footer Styles */
    .profile-footer {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }

    .last-update {
        color: #a0aec0;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
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
            padding: 70px 25px 25px;
        }
        
        .profile-header {
            height: 120px;
        }
        
        .avatar-circle {
            width: 80px;
            height: 80px;
        }
        
        .avatar-circle i {
            font-size: 2rem;
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
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnIcon = submitBtn.querySelector('.btn-icon');
            
            btnText.textContent = 'Memperbarui...';
            btnIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
        });

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