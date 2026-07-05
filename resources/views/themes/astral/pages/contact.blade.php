@extends('themes.astral.layouts.marketing')

@section('title', 'Astral Contact')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-white fw-bold display-4 mb-3">Astral Portal Helpline</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Transmit secure queries to our portal administrators. Our latency response threshold is under 2 hours.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="mkt-card p-5 h-100 d-flex flex-column gap-4">
                        <h2 class="h3 fw-bold text-white mb-2">Secure Channels</h2>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3" style="background: rgba(219, 70, 239, 0.1); border: 1px solid rgba(219, 70, 239, 0.2);">
                                <i class="bi bi-envelope-fill" style="color: #d946ef;"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">Direct Telemetry Link</h4>
                                <p class="small text-muted mb-0">support@saastarter.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3" style="background: rgba(219, 70, 239, 0.1); border: 1px solid rgba(219, 70, 239, 0.2);">
                                <i class="bi bi-clock-fill" style="color: #d946ef;"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">Processing Cycle</h4>
                                <p class="small text-muted mb-0">Mon – Fri, 9am – 6pm UTC</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3" style="background: rgba(219, 70, 239, 0.1); border: 1px solid rgba(219, 70, 239, 0.2);">
                                <i class="bi bi-geo-alt-fill" style="color: #d946ef;"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-white mb-1">HQ Coordinates</h4>
                                <p class="small text-muted mb-0">Orbit Node 7, Nebula Gateway</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="mkt-card p-5">
                        <h2 class="h3 fw-bold text-white mb-4">Transmit Query</h2>
                        
                        <form action="#" method="POST" class="d-flex flex-column gap-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Identity Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name" required 
                                           style="background: rgba(22, 14, 42, 0.4); border: 1px solid rgba(219, 70, 239, 0.15); color: #fff;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter email" required 
                                           style="background: rgba(22, 14, 42, 0.4); border: 1px solid rgba(219, 70, 239, 0.15); color: #fff;">
                                </div>
                            </div>

                            <div>
                                <label class="form-label text-muted small">Payload Signal (Message)</label>
                                <textarea class="form-control" rows="5" placeholder="Describe query details..." required 
                                          style="background: rgba(22, 14, 42, 0.4); border: 1px solid rgba(219, 70, 239, 0.15); color: #fff;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-mkt-primary py-3 w-100 mt-2">
                                <i class="bi bi-send-fill me-2"></i>Transmit Packet
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
