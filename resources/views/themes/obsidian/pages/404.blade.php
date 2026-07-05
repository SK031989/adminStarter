@extends('themes.obsidian.layouts.marketing')

@section('title', '404 - Lost in the Deep')

@section('content')
    <section class="py-5 text-center position-relative min-vh-75 d-flex align-items-center justify-content-center">
        <div class="container py-5">
            <div class="mkt-card p-5 mx-auto" style="max-width: 600px;">
                <div class="display-1 fw-bold text-primary mb-3" style="color: #6366f1 !important; text-shadow: 0 0 20px rgba(99, 102, 241, 0.3);">404</div>
                <h1 class="text-white fw-bold mb-3 h2">Lost in the Deep</h1>
                <p class="text-muted mb-4">The route you requested has collapsed into a cosmic black hole. Warp back safely to normal coordinates.</p>
                <div>
                    <a href="{{ route('marketing.index') }}" class="btn btn-mkt-primary">
                        Warp back Home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
