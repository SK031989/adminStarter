@extends('auth-module::layouts.auth')

@section('title', 'Admin Log In')

@section('left-bottom')
{{-- Super Admin seeded credentials card (Visible only on desktop left pane) --}}
<div class="card bg-danger bg-opacity-10 border border-danger border-opacity-20 p-3 text-start w-100" style="border-radius: 0.75rem;">
    <div class="small fw-semibold text-danger mb-1"><i class="bi bi-info-circle-fill me-1"></i>Default Admin Credentials</div>
    <div class="small text-light mb-1"><strong>Email:</strong> <code>admin@saas.local</code></div>
    <div class="small text-light"><strong>Password:</strong> <code>AdminPass123!</code></div>
</div>
@endsection

@section('content')
<div class="text-center mb-3">
    <span class="badge px-3 py-2 small fw-semibold" style="background: rgba(220, 53, 69, 0.2); color: #f87171; border: 1px solid rgba(220, 53, 69, 0.4);">
        <i class="bi bi-shield-lock me-1"></i>Administrator Area
    </span>
</div>
<h4 class="fw-bold mb-1 text-center">Super Admin Access</h4>
<p class="text-muted small mb-4 text-center">Authorized personnel only. Please sign in to proceed.</p>

{{-- Super Admin seeded credentials card (Visible only on mobile/tablet) --}}
<div class="card bg-danger bg-opacity-10 border border-danger border-opacity-20 p-3 mb-4 text-start d-lg-none" style="border-radius: 0.75rem;">
    <div class="small fw-semibold text-danger mb-1"><i class="bi bi-info-circle-fill me-1"></i>Default Admin Credentials</div>
    <div class="small text-light mb-1"><strong>Email:</strong> <code>admin@saas.local</code></div>
    <div class="small text-light"><strong>Password:</strong> <code>AdminPass123!</code></div>
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

<form action="{{ route('admin.login.store') }}" method="POST">
    @csrf

    {{-- Email Address --}}
    <div class="mb-3">
        <label for="email" class="form-label">Admin Email</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-envelope-check"></i>
            </span>
            <input type="email" name="email" id="email" 
                class="form-control border-start-0 @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                placeholder="admin@saas.local" 
                required autofocus style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-lock-fill"></i>
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
        <label class="form-check-label small" for="remember" style="color: #cbd5e1;">Remember me on this device</label>
    </div>

    {{-- Submit Button --}}
    <button type="submit" class="btn btn-danger w-100 mb-3">
        <i class="bi bi-shield-shaded me-2"></i>Authenticate Admin
    </button>

    <div class="text-center small">
        <a href="{{ route('auth.login') }}" style="color: #94a3b8;"><i class="bi bi-arrow-left me-1"></i>Back to User Login</a>
    </div>
</form>
@endsection
