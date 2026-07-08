@extends('layouts.front')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="bg-white p-5 rounded-4 shadow-lg border-0 position-relative overflow-hidden" style="transition: all 0.3s ease;">
                <!-- Brand Accent -->
                <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, var(--primary-color), #212121);"></div>
                
                <div class="text-center mb-5">
                    <img src="/logo-icon.png" class="mb-3" alt="Nexora" style="height: 60px;">
                    <h2 class="fw-bold" style="color: #1c1e21;">Welcome Back!</h2>
                    <p class="text-muted small">Please enter your details to sign in to your Nexora account.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3"><i class="bi bi-envelope text-muted"></i></span>
                            <input id="email" type="email" class="form-control bg-light border-start-0 rounded-end-pill py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="user@example.com">
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block mt-1 small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-muted text-uppercase d-flex justify-content-between">
                            Password
                            @if (Route::has('password.request'))
                                <a class="text-primary-theme text-decoration-none" href="{{ route('password.request') }}" style="font-size: 11px;">Forgot?</a>
                            @endif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3"><i class="bi bi-lock text-muted"></i></span>
                            <input id="password" type="password" class="form-control bg-light border-start-0 rounded-end-pill py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block mt-1 small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Keep me signed in
                            </label>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary-theme text-white py-3 rounded-pill fw-bold shadow-sm transition-lift">
                            Sign In to Nexora
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-primary-theme fw-bold text-decoration-none">Create Account</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- Dynamic Background elements (Subtle) -->
            <div class="mt-4 text-center text-muted small opacity-50">
                <i class="bi bi-shield-lock-fill me-1"></i> Secure SSL Encrypted Connection
            </div>
        </div>
    </div>
</div>

<style>
    .transition-lift { transition: all 0.2s ease; }
    .transition-lift:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important; }
    .input-group-text { border-color: #eee; }
    .form-control:focus { box-shadow: none; border-color: #eee; }
    .card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
</style>
@endsection
