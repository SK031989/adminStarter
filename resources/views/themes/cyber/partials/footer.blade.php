<footer class="py-5 mt-auto border-top-2">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-3">
                    &gt; CYBER_NET_NODE
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    [SYS_STATUS: ONLINE]
                    SaaS bootstrap template for hacking high-performance modules. Fully decoupled, terminal responsive.
                </p>
                <div class="d-flex gap-3 text-muted">
                    <a href="#" class="text-reset hover-neon"><span class="small">[TWIT]</span></a>
                    <a href="#" class="text-reset hover-neon"><span class="small">[GIT]</span></a>
                    <a href="#" class="text-reset hover-neon"><span class="small">[DISC]</span></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">&gt; DIR_MAP</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted hover-neon">/root</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted hover-neon">/features</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted hover-neon">/pricing</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted hover-neon">/contact</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-bold mb-3">&gt; SYS_GATEWAYS</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted hover-neon">/auth/login</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted hover-neon">/auth/register</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted hover-neon text-warning">/admin/console</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4" style="border-color: #1e293b; border-top-width: 2px;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">// &copy; {{ date('Y') }} {{ config('app.name', 'SaaSStater') }}. telemetry channel secure.</span>
            <span class="small text-muted">DESIGN: TERM_CORE // ANTIGRAVITY_AI</span>
        </div>
    </div>
</footer>

<style>
.hover-neon:hover {
    color: #06b6d4 !important;
    text-shadow: 0 0 5px #06b6d4;
}
</style>
