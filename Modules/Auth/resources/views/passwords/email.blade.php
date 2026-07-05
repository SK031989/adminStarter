@extends('auth-module::layouts.auth')

@section('title', 'Reset Password')

@section('content')
<h4 class="fw-bold mb-1">Forgot Password?</h4>
<p class="text-muted small mb-4">No problem. Enter your email address to receive a password reset link.</p>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center small py-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

<form action="{{ route('auth.password.email') }}" method="POST">
    @csrf

    {{-- Email Address --}}
    <div class="mb-4">
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

    {{-- Submit Button --}}
    <button type="submit" class="btn btn-primary w-100 mb-3">
        Email Password Reset Link
    </button>

    <div class="text-center small text-muted">
        Remember your password? <a href="{{ route('auth.login') }}">Back to login</a>
    </div>
</form>
@endsection
