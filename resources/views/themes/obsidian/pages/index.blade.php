@extends('themes.obsidian.layouts.marketing')

@section('title', 'Obsidian Dark Home')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 my-lg-5 text-center position-relative overflow-hidden">
        <div class="container py-5 position-relative z-1">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.3); color: #818cf8;">
                <i class="bi bi-stars me-1"></i> Cosmic Release v1.0
            </span>
            <h1 class="display-3 fw-bold text-white mb-3">Obsidian Cosmic Dark</h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 650px;">
                Sleek midnight backgrounds, glowing design elements, and responsive custom modules designed directly under resources folder.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    Explore Obsidian Starter
                </a>
                <a href="#features" class="btn btn-mkt-outline px-4 py-3">
                    Orbit System Features
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-white mb-2">Cosmos Architecture Core</h2>
                <p class="text-muted">High-performance schemas running dynamically under modular controllers.</p>
            </div>
            
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6 col-lg-3">
                        <div class="mkt-card p-4 h-100 d-flex flex-column text-center text-md-start">
                            <div class="fs-2 text-primary mb-3">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}" style="color: #a855f7;"></i>
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
    <section id="pricing" class="py-5 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold text-white mb-2">Cosmic Subscription Matrices</h2>
                <p class="text-muted">Upgrade telemetry parameters, database workspaces, and account structures dynamically.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="mkt-card p-4 h-100 d-flex flex-column position-relative {{ $plan['popular'] ? 'border-primary' : '' }}" 
                             style="{{ $plan['popular'] ? 'border-color: #818cf8 !important; box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.3);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge position-absolute top-0 end-0 translate-middle-y me-4 px-3 py-2 rounded-pill" 
                                      style="background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 0.75rem;">
                                    STELLAR CHOICE
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
                 style="background: rgba(31, 41, 55, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px);">
                <h2 class="h1 fw-bold text-white mb-3">Begin Cosmos Orbit</h2>
                <p class="text-muted mx-auto mb-4" style="max-width: 580px;">
                    Spin up your custom schema layout and secure 2FA dashboard environment in minutes.
                </p>
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    Initialize Free Node
                </a>
            </div>
        </div>
    </section>
@endsection
