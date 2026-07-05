<footer class="py-5 mt-auto border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-moon-stars-fill text-primary"></i> OBSIDIAN_COSMOS
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    A premium obsidian cosmic dark themed dashboard starter designed with high-quality visual grids.
                </p>
                <div class="d-flex gap-3 text-muted">
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-discord"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-semibold mb-3">Nebula Map</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted hover-cosmic">Home Orbit</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted hover-cosmic">Features Grid</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted hover-cosmic">Price Matrix</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted hover-cosmic">Comm Channel</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-semibold mb-3">System Gateways</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted hover-cosmic">Admin Login</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted hover-cosmic">Workspace Register</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted hover-cosmic text-warning">Admin Console</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 opacity-10" style="background-color: #6366f1;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'SaaSStater') }}. Telemetry link is operational.</span>
            <span class="small text-muted">Core Engine: Antigravity AI.</span>
        </div>
    </div>
</footer>

<style>
.hover-cosmic {
    transition: color 0.2s ease, text-shadow 0.2s ease;
}
.hover-cosmic:hover {
    color: #a855f7 !important;
    text-shadow: 0 0 8px rgba(168, 85, 247, 0.5);
}
</style>
