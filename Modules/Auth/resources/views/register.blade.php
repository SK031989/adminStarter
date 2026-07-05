@extends('auth-module::layouts.auth')

@section('title', 'Register')

@section('content')
<h4 class="fw-bold mb-1">Create Account</h4>
<p class="text-muted small mb-4">Get started with your free SaaS trial today.</p>

<form action="{{ route('auth.register.store') }}" method="POST">
    @csrf

    {{-- Full Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-person"></i>
            </span>
            <input type="text" name="name" id="name" 
                class="form-control border-start-0 @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                placeholder="John Doe" 
                required autofocus style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

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
                required style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- SaaS Company Name (if configured) --}}
    @if(config('auth-module.tenant.auto_create', false))
    <div class="mb-3">
        <label for="company_name" class="form-label">Company Name</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-building"></i>
            </span>
            <input type="text" name="company_name" id="company_name" 
                class="form-control border-start-0 @error('company_name') is-invalid @enderror" 
                value="{{ old('company_name') }}" 
                placeholder="Acme Corp" 
                required style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('company_name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    @endif

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" id="password" 
                class="form-control border-start-0 @error('password') is-invalid @enderror" 
                placeholder="••••••••" 
                required style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                class="form-control border-start-0" 
                placeholder="••••••••" 
                required style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
    </div>

    {{-- Submit Button --}}
    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-person-plus me-2"></i>Sign Up
    </button>

    <div class="text-center small text-muted">
        Already have an account? <a href="{{ route('auth.login') }}">Log In</a>
    </div>
</form>
@endsection
