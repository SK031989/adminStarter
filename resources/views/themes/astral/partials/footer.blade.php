<footer class="py-5 mt-auto border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-activity text-danger"></i> ASTRAL_PORTAL
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    A futuristic SaaS landing starter with high-end glassmorphism elements, dynamic components, and a robust admin controller.
                </p>
                <div class="d-flex gap-3 text-muted">
                    <a href="#" class="text-reset"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-reset"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-reset"><i class="bi bi-discord"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-semibold mb-3">Quick Navigation</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted hover-link">Home Portal</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted hover-link">System Features</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted hover-link">Subscription Plan</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted hover-link">Support Node</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-semibold mb-3">Platform Operations</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted hover-link">Gateway Login</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted hover-link">Workspace Register</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted hover-link text-warning">Admin Console</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 opacity-10" style="background-color: #d946ef;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'SaaSStater') }}. All telemetry channels secure.</span>
            <span class="small text-muted">Aesthetics by Antigravity AI.</span>
        </div>
    </div>
</footer>

<style>
.hover-link {
    transition: color 0.2s ease;
}
.hover-link:hover {
    color: #d946ef !important;
}
</style>
