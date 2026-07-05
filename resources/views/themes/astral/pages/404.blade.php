@extends('themes.astral.layouts.marketing')

@section('title', '404 - Lost in Orbit')

@section('content')
    <section class="py-5 text-center position-relative min-vh-75 d-flex align-items-center justify-content-center">
        <div class="container py-5">
            <div class="mkt-card p-5 mx-auto" style="max-width: 600px;">
                <div class="display-1 fw-bold text-primary mb-3" style="color: #d946ef !important;">404</div>
                <h1 class="text-white fw-bold mb-3 h2">Lost in Orbit</h1>
                <p class="text-muted mb-4">The telemetry coordinates you requested do not exist or the data packet has drifted out of range.</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('marketing.index') }}" class="btn btn-mkt-primary">
                        Return to Base Node
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
