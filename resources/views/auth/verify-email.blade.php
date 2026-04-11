@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-envelope-check fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Verifikasi Email Anda</h4>
                        <p class="text-muted small">Langkah terakhir untuk mengaktifkan akun Anda</p>
                    </div>

                    <!-- Info Text -->
                    <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-3 mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-info me-2 mt-1"></i>
                            <p class="mb-0 small">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success bg-success bg-opacity-10 border-0 rounded-3 mb-4">
                            <div class="d-flex">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <p class="mb-0 small">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4">
                        <form method="POST" action="{{ route('verification.send') }}" class="w-100 w-sm-auto">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 px-4 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-envelope-paper me-2"></i>
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="w-100 w-sm-auto">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>

                    <!-- Help Text -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-question-circle me-1"></i>
                            Tidak menerima email? Periksa folder spam Anda
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection