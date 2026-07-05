@extends('themes.cyber.layouts.marketing')

@section('title', '404 - [STATUS_CODE_NOT_FOUND]')

@section('content')
    <section class="py-5 text-center position-relative min-vh-75 d-flex align-items-center justify-content-center">
        <div class="container py-5">
            <div class="mkt-card p-5 mx-auto text-start" style="max-width: 650px; font-family: 'Courier Prime', monospace;">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4" style="border-color: var(--card-border) !important;">
                    <span class="text-danger fw-bold">> SYSTEM_ALERT_ERROR</span>
                    <span class="text-muted small">ID: 0x404_NF</span>
                </div>
                <div class="display-3 fw-bold mb-3" style="color: var(--cyan-neon) !important;">ERROR: 404</div>
                <h1 class="text-white fw-bold mb-3 h4">> [STATUS_CODE_NOT_FOUND]</h1>
                <p class="text-muted mb-4">> The requested page file could not be compiled or executed. Sector not found in system directory tables.</p>
                <div class="mb-4 p-3 rounded" style="background: rgba(0, 0, 0, 0.2); border-left: 3px solid var(--cyan-neon);">
                    <code style="color: var(--cyan-neon) !important; font-size: 0.9rem;">
                        sh-5.2$ query_route --uri="{{ request()->path() }}"<br>
                        [RESPONSE]: ROUTE_ENTRY_MISSING (CODE 404)
                    </code>
                </div>
                <div>
                    <a href="{{ route('marketing.index') }}" class="btn btn-mkt-primary">
                        [REBOOT_TO_HOME]
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
