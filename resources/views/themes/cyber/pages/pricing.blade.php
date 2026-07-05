@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Pricing')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">&gt; SUBSCRIPTION_NODE_LEVELS</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Unlock system resources dynamically depending on workspace compile count requirements.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="mkt-card p-5 h-100 d-flex flex-column position-relative"
                             style="{{ $plan['popular'] ? 'border-color: #06b6d4 !important; box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge position-absolute top-0 end-0 translate-middle-y me-5 px-3 py-1 rounded-0" 
                                      style="background: #06b6d4; color: #020617; font-size: 0.7rem; font-weight: bold;">
                                    [SYS_CHOICE]
                                </span>
                            @endif

                            <div class="mb-4">
                                <h3 class="h4 fw-bold text-white mb-2">&gt; {{ $plan['name'] }}</h3>
                                <p class="small text-muted">{{ $plan['description'] }}</p>
                                <div class="d-flex align-items-baseline text-white my-4">
                                    <span class="fs-2">$</span>
                                    <span class="fs-1 fw-bold">{{ $plan['price'] }}</span>
                                    <span class="text-muted ms-2">/ {{ $plan['period'] }}</span>
                                </div>
                            </div>

                            <hr style="border-color: #1e293b; border-top-width: 2px;">

                            <ul class="list-unstyled d-flex flex-column gap-3 mb-5 flex-grow-1">
                                @foreach($plan['features'] as $f)
                                    <li class="d-flex align-items-center gap-2 small text-muted">
                                        <span class="text-info">[+]</span>
                                        <span>{{ $f }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ Route::has($plan['route']) ? route($plan['route']) : '#' }}" 
                               class="btn {{ $plan['popular'] ? 'btn-mkt-primary' : 'btn-mkt-outline' }} w-100 py-3">
                                {{ $plan['button'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 border-top" style="border-color: #1e293b !important; border-top-width: 2px;">
        <div class="container" style="max-width: 800px;">
            <h2 class="h4 fw-bold text-white text-center mb-5">&gt; TELEMETRY_MATRIX_FAQ</h2>
            <div class="d-flex flex-column gap-4">
                <div class="mkt-card p-4">
                    <h4 class="h6 fw-bold text-white mb-2">// CAN_TIERS_BE_RECONFIGURED?</h4>
                    <p class="small text-muted mb-0 leading-relaxed">Yes, all modifications to your system subscription nodes are prorated instantly. Change tiers dynamically in the admin console dashboard.</p>
                </div>
                <div class="mkt-card p-4">
                    <h4 class="h6 fw-bold text-white mb-2">// LIMIT_RESET_FREQUENCY</h4>
                    <p class="small text-muted mb-0 leading-relaxed">Workspace limit bounds and background queue memory resets occur precisely at the start of each billing cycle.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
