@extends('auth-module::layouts.auth')

@section('title', 'Log In')

@section('left-bottom')
{{-- Default User Credentials (Visible only on desktop left pane) --}}
<div class="card bg-primary bg-opacity-10 border border-primary border-opacity-20 p-3 text-start w-100" style="border-radius: 0.75rem;">
    <div class="small fw-semibold text-primary mb-1"><i class="bi bi-info-circle-fill me-1"></i>Default User Credentials</div>
    <div class="small text-light mb-1"><strong>Tenant Admin:</strong> <code>tenant1@saas.local</code> / <code>TenantPass123!</code></div>
    <div class="small text-light"><strong>Demo User:</strong> <code>user@saas.local</code> / <code>UserPass123!</code></div>
</div>
@endsection

@section('content')
<h4 class="fw-bold mb-1">Welcome Back</h4>
<p class="text-muted small mb-4">Please enter your credentials to access your account.</p>

{{-- Default User Credentials (Visible only on mobile/tablet) --}}
<div class="card bg-primary bg-opacity-10 border border-primary border-opacity-20 p-3 mb-4 text-start d-lg-none" style="border-radius: 0.75rem;">
    <div class="small fw-semibold text-primary mb-1"><i class="bi bi-info-circle-fill me-1"></i>Default User Credentials</div>
    <div class="small text-light mb-1"><strong>Tenant Admin:</strong> <code>tenant1@saas.local</code> / <code>TenantPass123!</code></div>
    <div class="small text-light"><strong>Demo User:</strong> <code>user@saas.local</code> / <code>UserPass123!</code></div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center small py-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center small py-2 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

<form action="{{ route('auth.login.store') }}" method="POST">
    @csrf

    {{-- Email Address --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-envelope"></i>
            </span>
            <input type="email" name="email" id="email" 
                class="form-control border-start-0 @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                placeholder="name@company.com" 
                required autofocus style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label mb-0">Password</label>
            <a href="{{ route('auth.password.request') }}" class="small">Forgot password?</a>
        </div>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" id="password" 
                class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                placeholder="••••••••" 
                required style="border-radius: 0;">
            <span class="input-group-text-toggle password-toggle-btn" data-target="password">
                <i class="bi bi-eye-slash"></i>
            </span>
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Remember Me --}}
    <div class="mb-4 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label text-muted small" for="remember">Remember me on this device</label>
    </div>

    {{-- Submit Button --}}
    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>

    @if(config('auth-module.registration.enabled', true))
        <div class="text-center small text-muted">
            Don't have an account? <a href="{{ route('auth.register') }}">Create an account</a>
        </div>
    @endif
</form>
@endsection
