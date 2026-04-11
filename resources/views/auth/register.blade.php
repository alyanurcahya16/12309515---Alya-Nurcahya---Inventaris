@extends('layouts.main')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3 shadow-sm">
                        <i class="bi bi-person-plus fs-1 text-primary"></i>
                    </div>
                    <h2 class="fw-bold mb-2">
                        Buat Akun<span class="text-primary">.</span>
                    </h2>
                    <p class="text-muted small fw-medium">
                        Daftar untuk mulai mengelola inventaris
                    </p>
                </div>

                <!-- Register Form -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label text-uppercase fw-bold small text-muted">
                                    Nama Lengkap
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control rounded-3 py-3 bg-light border-0 @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label text-uppercase fw-bold small text-muted">
                                    Email Address
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control rounded-3 py-3 bg-light border-0 @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       placeholder="nama@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password & Confirm Password -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label text-uppercase fw-bold small text-muted">
                                        Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="password" 
                                               id="password" 
                                               class="form-control rounded-3 py-3 bg-light border-0 @error('password') is-invalid @enderror" 
                                               placeholder="••••••••"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label text-uppercase fw-bold small text-muted">
                                        Confirm
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               class="form-control rounded-3 py-3 bg-light border-0" 
                                               placeholder="••••••••"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                                <div class="alert alert-danger alert-sm py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <!-- Password Hint -->
                            <div class="small text-muted mb-4">
                                <i class="bi bi-info-circle me-1"></i>
                                Password minimal 8 karakter
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-person-plus me-2"></i>
                                Daftar Sekarang
                            </button>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
@endsection