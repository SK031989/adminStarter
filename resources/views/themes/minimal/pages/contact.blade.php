@extends('themes.minimal.layouts.marketing')

@section('title', 'Minimal Contact')

@section('content')
    <section class="py-5 text-center position-relative">
        <div class="container py-5">
            <h1 class="text-dark fw-bold display-4 mb-3">Get in Touch</h1>
            <p class="text-muted lead mx-auto" style="max-width: 600px;">Ping our team directly. We typically respond within two business hours.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="mkt-card p-5 h-100 d-flex flex-column gap-4 bg-white border">
                        <h2 class="h3 fw-bold text-dark mb-2">Contact Details</h2>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3 bg-light border">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-dark mb-1">Email Support</h4>
                                <p class="small text-muted mb-0">support@saastarter.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3 bg-light border">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-dark mb-1">Business Hours</h4>
                                <p class="small text-muted mb-0">Mon – Fri, 9am – 6pm UTC</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3 text-primary p-2.5 rounded-3 bg-light border">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold text-dark mb-1">Office Location</h4>
                                <p class="small text-muted mb-0">100 Tech Boulevard, Suite 500</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="mkt-card p-5 bg-white border">
                        <h2 class="h3 fw-bold text-dark mb-4">Send a Message</h2>
                        
                        <form action="#" method="POST" class="d-flex flex-column gap-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Your Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name" required 
                                           style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a; border-radius: 0.375rem;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter email" required 
                                           style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a; border-radius: 0.375rem;">
                                </div>
                            </div>

                            <div>
                                <label class="form-label text-muted small">Your Message</label>
                                <textarea class="form-control" rows="5" placeholder="Enter your message details..." required 
                                          style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a; border-radius: 0.375rem;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-mkt-primary py-3 w-100 mt-2">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
