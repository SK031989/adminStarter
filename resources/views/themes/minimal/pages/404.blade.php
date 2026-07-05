@extends('themes.minimal.layouts.marketing')

@section('title', '404 - Page Not Found')

@section('content')
    <section class="py-5 text-center position-relative min-vh-75 d-flex align-items-center justify-content-center">
        <div class="container py-5">
            <div class="mkt-card p-5 mx-auto" style="max-width: 550px;">
                <div class="display-1 fw-bold text-secondary mb-2" style="font-size: 5rem;">404</div>
                <h1 class="text-white fw-bold mb-3 h3">Page Not Found</h1>
                <p class="text-muted mb-4">We can't find the page you're looking for. It might have been moved, deleted, or never existed in the first place.</p>
                <div>
                    <a href="{{ route('marketing.index') }}" class="btn btn-mkt-primary px-4 py-2.5">
                        Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
