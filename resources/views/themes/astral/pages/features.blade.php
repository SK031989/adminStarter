@extends('themes.astral.layouts.marketing')

@section('title', 'Astral Features')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">Astral Portal Architecture</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Explore the technical parameters and dynamic database components that power the {{ config('app.name', 'SaaSStater') }} console.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @foreach($features as $feat)
                    <div class="col-md-6">
                        <div class="mkt-card p-5 h-100 d-flex gap-4 align-items-start">
                            <div class="fs-1 text-primary p-3 rounded-4" style="background: rgba(219, 70, 239, 0.1); border: 1px solid rgba(219, 70, 239, 0.2);">
                                <i class="bi {{ $feat['icon'] ?? 'bi-cpu' }}" style="color: #d946ef;"></i>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold text-white mb-2">{{ $feat['title'] }}</h3>
                                <p class="text-muted leading-relaxed mb-0">{{ $feat['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technical Specs -->
    <section class="py-5 border-top" style="border-color: rgba(219, 70, 239, 0.1) !important;">
        <div class="container">
            <div class="mkt-card p-5 rounded-4">
                <h2 class="h3 fw-bold text-white mb-4 text-center">System Integration Telemetry</h2>
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-white mb-1">&lt; 2ms</div>
                        <p class="small text-muted mb-0">Query Latency</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-white mb-1">99.99%</div>
                        <p class="small text-muted mb-0">Uptime SLA</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-white mb-1">256-bit</div>
                        <p class="small text-muted mb-0">AES Encryption</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="display-6 fw-bold text-white mb-1">2FA</div>
                        <p class="small text-muted mb-0">Identity Guard</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
