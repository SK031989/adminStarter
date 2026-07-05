@extends('themes.minimal.layouts.marketing')

@section('title', 'Minimal Features')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-dark fw-bold display-4 mb-3">Core Platform Capabilities</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Explore the robust features and customizable structures that power {{ config('app.name', 'SaaSStater') }}.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6">
                        <div class="mkt-card p-5 h-100 d-flex gap-4 align-items-start">
                            <div class="fs-1 text-primary p-3 rounded-4 bg-light border">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}"></i>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold text-dark mb-2">{{ $feat['title'] }}</h3>
                                <p class="text-muted leading-relaxed mb-0 small">{{ $feat['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technical Specs -->
    <section class="py-5 border-top" style="border-color: #e2e8f0 !important;">
        <div class="container">
            <div class="mkt-card p-5 rounded-4 bg-white shadow-sm border">
                <h2 class="h3 fw-bold text-dark mb-4 text-center">System Integration Specs</h2>
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-dark mb-1">&lt; 2ms</div>
                        <p class="small text-muted mb-0">Query Latency</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-dark mb-1">99.99%</div>
                        <p class="small text-muted mb-0">Uptime SLA</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-dark mb-1">256-bit</div>
                        <p class="small text-muted mb-0">AES Encryption</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-dark mb-1">Active</div>
                        <p class="small text-muted mb-0">2FA Security</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
