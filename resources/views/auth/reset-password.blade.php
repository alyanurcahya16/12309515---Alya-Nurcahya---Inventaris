@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-key fs-1 text-warning"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Reset Password</h4>
                        <p class="text-muted small">Buat password baru untuk akun Anda</p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>
                                {{ __('Email Address') }}
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $request->email) }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="nama@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i>
                                {{ __('New Password') }}
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-control rounded-3 py-2 @error('password') is-invalid @enderror" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Masukkan password baru">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted mt-1 d-block">Minimal 8 karakter, mengandung huruf dan angka</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-shield-lock me-1"></i>
                                {{ __('Confirm Password') }}
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control rounded-3 py-2" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Konfirmasi password baru">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary py-2 rounded-3 fw-semibold">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none small">
                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali ke halaman login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Setelah reset password, Anda akan dapat login dengan password baru
                </small>
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