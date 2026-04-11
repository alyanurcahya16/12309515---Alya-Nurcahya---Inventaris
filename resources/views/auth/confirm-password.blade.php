@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-shield-lock fs-3 text-danger"></i>
                        </div>
                        <h3 class="fw-bold mb-1">Konfirmasi Password</h3>
                        <p class="text-muted small">
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control rounded-3 @error('password') is-invalid @enderror" 
                                       placeholder="Masukkan password Anda"
                                       required 
                                       autocomplete="current-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                            <i class="bi bi-check-lg me-2"></i>
                            {{ __('Confirm') }}
                        </button>
                    </form>
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