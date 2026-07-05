@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Home')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 my-lg-5 position-relative">
        <div class="container py-5 text-center">
            <span class="d-inline-block border border-info px-3 py-1 mb-3 text-info small" style="background: rgba(6, 182, 212, 0.05);">
                &gt;&gt; SYSTEM_INITIALIZED_OK
            </span>
            <h1 class="display-4 fw-bold text-white mb-3">
                &gt; CYBER_CORE_TERMINAL
            </h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 650px;">
                Low latency modules, flat structure data models, and direct routing structures for building resilient cybernetic architectures.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    [REGISTER_NODE]
                </a>
                <a href="#features" class="btn btn-mkt-outline px-4 py-3">
                    [READ_SPECS]
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 border-top" style="border-color: #1e293b !important; border-top-width: 2px;">
        <div class="container">
            <div class="mb-5">
                <h2 class="h2 fw-bold text-white mb-2">&gt;&gt; MODULE_SPECS</h2>
                <p class="text-muted small">Available core structures running in background memory stacks.</p>
            </div>
            
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6 col-lg-3">
                        <div class="mkt-card p-4 h-100 d-flex flex-column">
                            <div class="fs-4 text-info mb-3">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}"></i>
                            </div>
                            <h3 class="h6 fw-bold text-white mb-2">// {{ $feat['title'] }}</h3>
                            <p class="small text-muted mb-0 leading-relaxed">{{ $feat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 border-top" style="border-color: #1e293b !important; border-top-width: 2px;">
        <div class="container">
            <div class="mb-5">
                <h2 class="h2 fw-bold text-white mb-2">&gt;&gt; TELEMETRY_COST_MATRIX</h2>
                <p class="text-muted small">Subscription parameters and resource limits map.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="mkt-card p-4 h-100 d-flex flex-column position-relative" 
                             style="{{ $plan['popular'] ? 'border-color: #06b6d4 !important; box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge position-absolute top-0 end-0 translate-middle-y me-4 px-3 py-1 rounded-0" 
                                      style="background: #06b6d4; color: #020617; font-size: 0.7rem; font-weight: bold;">
                                    [SYS_CHOICE]
                                </span>
                            @endif

                            <div class="mb-4">
                                <h3 class="h5 fw-bold text-white mb-2">&gt; {{ $plan['name'] }}</h3>
                                <p class="small text-muted">{{ $plan['description'] }}</p>
                                <div class="d-flex align-items-baseline text-white my-3">
                                    <span class="fs-3">$</span>
                                    <span class="fs-1 fw-bold">{{ $plan['price'] }}</span>
                                    <span class="text-muted ms-2">/ {{ $plan['period'] }}</span>
                                </div>
                            </div>

                            <hr style="border-color: #1e293b; border-top-width: 2px;">

                            <ul class="list-unstyled d-flex flex-column gap-2 mb-5 flex-grow-1">
                                @foreach($plan['features'] as $f)
                                    <li class="d-flex align-items-center gap-2 small text-muted">
                                        <span class="text-info">[+]</span>
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
    <section class="py-5">
        <div class="container">
            <div class="p-5 text-center mkt-card">
                <h2 class="h3 fw-bold text-white mb-3">&gt; COMPILE_NOW</h2>
                <p class="text-muted mx-auto mb-4" style="max-width: 580px;">
                    Spin up your cybernetic database models and async job queues inside a sandbox environment immediately.
                </p>
                <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">
                    [INITIALIZE_WORKSPACE_FREE]
                </a>
            </div>
        </div>
    </section>
@endsection
