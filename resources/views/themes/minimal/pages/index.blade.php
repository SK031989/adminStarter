@extends('themes.minimal.layouts.marketing')

@section('title', 'Minimal Home')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 my-lg-5 text-center position-relative">
        <div class="container py-5">
            <span class="badge bg-light text-primary border px-3 py-2 mb-3 rounded-pill" style="font-weight: 500;">
                SaaS Starter Framework v1.0
            </span>
            <h1 class="display-3 fw-bold text-dark mb-3">
                Minimalist Light Console
            </h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 650px;">
                Build lightweight, responsive multi-tenant SaaS platforms with dynamic visual module builders and job scheduler configurations.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    Start Building
                </a>
                <a href="#features" class="btn btn-mkt-outline px-4 py-3">
                    View Architecture
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 border-top" style="border-color: #e2e8f0 !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-dark mb-2">Core System Features</h2>
                <p class="text-muted">Simple, modular services running dynamically under your configurations.</p>
            </div>
            
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6 col-lg-3">
                        <div class="mkt-card p-4 h-100 d-flex flex-column text-center text-md-start">
                            <div class="fs-2 text-primary mb-3">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}"></i>
                            </div>
                            <h3 class="h5 fw-bold text-dark mb-2">{{ $feat['title'] }}</h3>
                            <p class="small text-muted mb-0 leading-relaxed">{{ $feat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 border-top" style="border-color: #e2e8f0 !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-dark mb-2">Flexible Subscription Plans</h2>
                <p class="text-muted">Choose a package that matches your operational workspace requirements.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="mkt-card p-4 h-100 d-flex flex-column position-relative {{ $plan['popular'] ? 'border-primary' : '' }}" 
                             style="{{ $plan['popular'] ? 'border-color: #3b82f6 !important; box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.15);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge bg-primary position-absolute top-0 end-0 translate-middle-y me-4 px-3 py-2 rounded-pill" 
                                      style="font-size: 0.75rem;">
                                    POPULAR CHOICE
                                </span>
                            @endif

                            <div class="mb-4">
                                <h3 class="h4 fw-bold text-dark mb-2">{{ $plan['name'] }}</h3>
                                <p class="small text-muted">{{ $plan['description'] }}</p>
                                <div class="d-flex align-items-baseline text-dark my-3">
                                    <span class="fs-2 fw-semibold">$</span>
                                    <span class="display-5 fw-bold">{{ $plan['price'] }}</span>
                                    <span class="text-muted ms-2">/ {{ $plan['period'] }}</span>
                                </div>
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-3 mb-5 flex-grow-1">
                                @foreach($plan['features'] as $f)
                                    <li class="d-flex align-items-center gap-2 small text-muted">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>{{ $f }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ Route::has($plan['route']) ? route($plan['route']) : '#' }}" 
                               class="btn {{ $plan['popular'] ? 'btn-mkt-primary' : 'btn-mkt-outline' }} w-100 py-3 mt-auto">
                                {{ $plan['button'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 my-lg-5">
        <div class="container">
            <div class="p-5 rounded-4 text-center bg-white border shadow-sm">
                <h2 class="h1 fw-bold text-dark mb-3">Initialize Workspace</h2>
                <p class="text-muted mx-auto mb-4" style="max-width: 580px;">
                    Spin up your custom schema layout and secure SaaS backend in minutes.
                </p>
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    Get Started Free
                </a>
            </div>
        </div>
    </section>
@endsection
