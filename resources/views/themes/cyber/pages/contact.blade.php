@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Contact')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">&gt; TRANSMIT_MESSAGE_TO_NODE</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Ping our operations division directly to report exceptions or hardware resource anomalies.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="mkt-card p-5 h-100 d-flex flex-column gap-4">
                        <h2 class="h5 fw-bold text-white mb-2">&gt; SYS_CONTACT_COORDS</h2>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-4 text-info p-2 border border-info" style="background: rgba(6, 182, 212, 0.05);">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">// EMAIL_ADDR</h4>
                                <p class="small text-muted mb-0">support@saastarter.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-4 text-info p-2 border border-info" style="background: rgba(6, 182, 212, 0.05);">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">// ACTIVE_HOURS</h4>
                                <p class="small text-muted mb-0">Mon – Fri, 9am – 6pm UTC</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-4 text-info p-2 border border-info" style="background: rgba(6, 182, 212, 0.05);">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">// SERVER_LOC</h4>
                                <p class="small text-muted mb-0">Sublevel 4, Silicon Vault 9</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="mkt-card p-5">
                        <h2 class="h5 fw-bold text-white mb-4">&gt; SEND_QUERY_PACKET</h2>
                        
                        <form action="#" method="POST" class="d-flex flex-column gap-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">// USERNAME</label>
                                    <input type="text" class="form-control" placeholder="input username" required 
                                           style="background: #020617; border: 2px solid #1e293b; color: #06b6d4; border-radius: 0; font-family: monospace;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">// EMAIL</label>
                                    <input type="email" class="form-control" placeholder="input email" required 
                                           style="background: #020617; border: 2px solid #1e293b; color: #06b6d4; border-radius: 0; font-family: monospace;">
                                </div>
                            </div>

                            <div>
                                <label class="form-label text-muted small">// PAYLOAD</label>
                                <textarea class="form-control" rows="5" placeholder="input message data..." required 
                                          style="background: #020617; border: 2px solid #1e293b; color: #06b6d4; border-radius: 0; font-family: monospace;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-mkt-primary py-3 w-100 mt-2">
                                [TRANSMIT_SIGNAL]
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
