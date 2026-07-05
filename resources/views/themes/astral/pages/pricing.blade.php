@extends('themes.astral.layouts.marketing')

@section('title', 'Astral Pricing')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">Astral Subscription Nodes</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Unlock access plans matching your SaaS operational limits with modular cost configurations.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach($pricing as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="mkt-card p-5 h-100 d-flex flex-column position-relative {{ $plan['popular'] ? 'border-primary' : '' }}"
                             style="{{ $plan['popular'] ? 'border-color: #d946ef !important; box-shadow: 0 8px 32px 0 rgba(219, 70, 239, 0.15);' : '' }}">
                            
                            @if($plan['popular'])
                                <span class="badge position-absolute top-0 end-0 translate-middle-y me-5 px-3 py-2 rounded-pill" 
                                      style="background: linear-gradient(135deg, #d946ef, #6366f1); font-size: 0.75rem;">
                                    RECOMMENDED
                                </span>
                            @endif

                            <div class="mb-4">
                                <h3 class="h3 fw-bold text-white mb-2">{{ $plan['name'] }}</h3>
                                <p class="small text-muted">{{ $plan['description'] }}</p>
                                <div class="d-flex align-items-baseline text-white my-4">
                                    <span class="fs-1 fw-semibold">$</span>
                                    <span class="display-4 fw-bold">{{ $plan['price'] }}</span>
                                    <span class="text-muted ms-2">/ {{ $plan['period'] }}</span>
                                </div>
                            </div>

                            <hr class="my-4 opacity-10" style="background-color: #d946ef;">

                            <ul class="list-unstyled d-flex flex-column gap-3 mb-5 flex-grow-1">
                                @foreach($plan['features'] as $f)
                                    <li class="d-flex align-items-center gap-2 small text-muted">
                                        <i class="bi bi-check-circle-fill text-success"></i>
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
    <section class="py-5 border-top" style="border-color: rgba(219, 70, 239, 0.1) !important;">
        <div class="container" style="max-width: 800px;">
            <h2 class="h3 fw-bold text-white text-center mb-5">Billing Telemetry FAQ</h2>
            <div class="d-flex flex-column gap-4">
                <div class="mkt-card p-4">
                    <h4 class="h6 fw-bold text-white mb-2">Can I upgrade or downgrade my tier?</h4>
                    <p class="small text-muted mb-0 leading-relaxed">Yes, all modifications to your system subscription nodes are prorated instantly. Change tiers dynamically in the admin console dashboard.</p>
                </div>
                <div class="mkt-card p-4">
                    <h4 class="h6 fw-bold text-white mb-2">What is the telemetry limit reset policy?</h4>
                    <p class="small text-muted mb-0 leading-relaxed">Workspace limit bounds and background queue memory resets occur precisely at the start of each billing cycle.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
