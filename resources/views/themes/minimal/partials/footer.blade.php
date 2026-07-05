<footer class="py-5 mt-auto border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-sun-fill text-warning"></i> {{ config('app.name', 'SaaSStater') }}
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    A clean, lightweight dashboard framework with modern light-mode grids and dynamic schema builders.
                </p>
                <div class="d-flex gap-3 text-muted">
                    <a href="#" class="text-reset hover-primary"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-reset hover-primary"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-reset hover-primary"><i class="bi bi-discord"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Navigation</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted hover-primary">Home</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted hover-primary">Features</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted hover-primary">Pricing</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted hover-primary">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-bold mb-3">Operations</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted hover-primary">Sign In</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted hover-primary">Get Started</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted hover-primary text-primary fw-semibold">Admin Panel</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'SaaSStater') }}. All rights reserved.</span>
            <span class="small text-muted">Aesthetics by Antigravity AI.</span>
        </div>
    </div>
</footer>

<style>
.hover-primary {
    transition: color 0.2s ease;
}
.hover-primary:hover {
    color: #3b82f6 !important;
}
</style>
