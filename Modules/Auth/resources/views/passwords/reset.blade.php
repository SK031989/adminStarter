@extends('auth-module::layouts.auth')

@section('title', 'Reset Password')

@section('content')
<h4 class="fw-bold mb-1">Set New Password</h4>
<p class="text-muted small mb-4">Please create a strong new password for your account.</p>

<form action="{{ route('auth.password.update') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    {{-- Email Address --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-envelope"></i>
            </span>
            <input type="email" name="email" id="email" 
                class="form-control border-start-0 @error('email') is-invalid @enderror" 
                value="{{ old('email', $email) }}" 
                placeholder="name@company.com" 
                required readonly style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem 0 0 0.75rem;">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" id="password" 
                class="form-control border-start-0 @error('password') is-invalid @enderror" 
                placeholder="••••••••" 
                required autofocus style="border-radius: 0 0.75rem 0.75rem 0;">
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
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
    <button type="submit" class="btn btn-primary w-100">
        Reset Password
    </button>
</form>
@endsection
