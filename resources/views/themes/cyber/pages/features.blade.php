@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Features')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">&gt; CORE_ARCHITECTURE_SPECS</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Review the telemetry indices and sandbox compilation tools built into {{ config('app.name', 'SaaSStater') }}.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6">
                        <div class="mkt-card p-5 h-100 d-flex gap-4 align-items-start">
                            <div class="fs-2 text-info p-3 border border-info" style="background: rgba(6, 182, 212, 0.05);">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold text-white mb-2">// {{ $feat['title'] }}</h3>
                                <p class="text-muted leading-relaxed mb-0 small">{{ $feat['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technical Specs -->
    <section class="py-5 border-top" style="border-color: #1e293b !important; border-top-width: 2px;">
        <div class="container">
            <div class="mkt-card p-5">
                <h2 class="h5 fw-bold text-white mb-4 text-center">&gt; SYSTEM_PERFORMANCE_METRICS</h2>
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="fs-3 fw-bold text-info mb-1">[ &lt; 2ms ]</div>
                        <p class="small text-muted mb-0">Latency</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="fs-3 fw-bold text-info mb-1">[ 99.99% ]</div>
                        <p class="small text-muted mb-0">Uptime SLA</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="fs-3 fw-bold text-info mb-1">[ AES-256 ]</div>
                        <p class="small text-muted mb-0">Crypto Guard</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="fs-3 fw-bold text-info mb-1">[ ENABLED ]</div>
                        <p class="small text-muted mb-0">2FA Telemetry</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
