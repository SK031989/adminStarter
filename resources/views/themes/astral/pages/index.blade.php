@extends('themes.astral.layouts.marketing')

@section('title', 'Astral Home')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 my-lg-5 text-center position-relative overflow-hidden">
        <div class="container py-5 position-relative z-1">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(219, 70, 239, 0.1); border: 1px solid rgba(219, 70, 239, 0.3); color: #d946ef;">
                <i class="bi bi-rocket-takeoff-fill me-1"></i> SaaS Starter v1.0
            </span>
            <h1 class="display-3 fw-bold text-white mb-3 leading-sm">
                Astral Nebula Portal
            </h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 650px;">
                Frosted glassmorphism panels, modular configuration components, and async state machine structures built for cutting edge developers.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    <i class="bi bi-shield-lock-fill me-2"></i>Register in Portal
                </a>
                <a href="#features" class="btn btn-mkt-outline px-4 py-3">
                    Learn Architecture
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-white mb-2">Portal Architecture Core</h2>
                <p class="text-muted">High-performance structures configured dynamically under resource structures.</p>
            </div>
            
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6 col-lg-3">
                        <div class="mkt-card p-4 h-100 d-flex flex-column text-center text-md-start">
                            <div class="fs-2 text-primary mb-3">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}" style="color: #c084fc;"></i>
                            </div>
                            <h3 class="h5 fw-bold text-white mb-2">{{ $feat['title'] }}</h3>
                            <p class="small text-muted mb-0 leading-relaxed">{{ $feat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 border-top" style="border-color: rgba(219, 70, 239, 0.1) !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-white mb-2">Portal Access Plans</h2>
                <p class="text-muted">Scale telemetry, active workspace nodes, and memory allocations instantly.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="mkt-card p-4 h-100 d-flex flex-column position-relative {{ $plan['popular'] ? 'border-primary' : '' }}" 
                             style="{{ $plan['popular'] ? 'border-color: #d946ef !important; box-shadow: 0 8px 32px 0 rgba(219, 70, 239, 0.15);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge position-absolute top-0 end-0 translate-middle-y me-4 px-3 py-2 rounded-pill" 
                                      style="background: linear-gradient(135deg, #d946ef, #6366f1); font-size: 0.75rem;">
                                    RECOMMENDED
                                </span>
                            @endif

                            <div class="mb-4">
                                <h3 class="h4 fw-bold text-white mb-2">{{ $plan['name'] }}</h3>
                                <p class="small text-muted">{{ $plan['description'] }}</p>
                                <div class="d-flex align-items-baseline text-white my-3">
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
            <div class="p-5 rounded-4 text-center position-relative overflow-hidden" 
                 style="background: rgba(22, 14, 42, 0.4); border: 1px solid rgba(219, 70, 239, 0.15); backdrop-filter: blur(16px);">
                <h2 class="h1 fw-bold text-white mb-3">Begin Portal Initialization</h2>
                <p class="text-muted mx-auto mb-4" style="max-width: 580px;">
                    Spin up your custom relational tables, 2FA credentials, and secure SaaS routing nodes in minutes.
                </p>
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    Create Free Workspace
                </a>
            </div>
        </div>
    </section>
@endsection
