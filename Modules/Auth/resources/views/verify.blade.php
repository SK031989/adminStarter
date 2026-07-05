@extends('auth-module::layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="text-center mb-4">
    <div class="p-3 rounded-circle bg-primary bg-opacity-10 d-inline-block text-primary fs-1 mb-3">
        <i class="bi bi-envelope-open-fill"></i>
    </div>
    <h4 class="fw-bold mb-1">Verify Your Email</h4>
    <p class="text-muted small mb-0">Thanks for signing up! Please verify your email address to unlock full access.</p>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center small py-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

<div class="text-muted small mb-4 text-center">
    We have sent a verification link to your email address. If you didn't receive it, click the button below to request another.
</div>

<form action="{{ route('auth.verify.resend') }}" method="POST" class="mb-3">
    @csrf
    <button type="submit" class="btn btn-primary w-100">
        Resend Verification Email
    </button>
</form>

<form action="{{ route('auth.logout') }}" method="POST" class="text-center">
    @csrf
    <button type="submit" class="btn btn-link text-muted small p-0 text-decoration-none">
        <i class="bi bi-box-arrow-left me-1"></i>Sign Out
    </button>
</form>
@endsection
