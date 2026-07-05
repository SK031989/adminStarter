<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') — {{ config('app.name', 'SaaS App') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0b0f19;
            color: #f8fafc;
            min-height: 100vh;
            overflow-x: hidden;
        }
        @media (min-width: 992px) {
            body {
                height: 100vh;
                overflow: hidden;
            }
            .left-visual-section,
            .right-form-section {
                height: 100vh;
                overflow-y: auto;
            }
        }
        .left-visual-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
        }
        .left-visual-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            filter: blur(120px);
            opacity: 0.15;
            bottom: -50px;
            left: -50px;
        }
        .left-visual-section::before {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: linear-gradient(135deg, #06b6d4, #10b981);
            filter: blur(100px);
            opacity: 0.12;
            top: -50px;
            right: -50px;
        }
        .right-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0b0f19;
            min-height: 100vh;
        }
        .auth-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 460px;
        }
        .auth-logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.25);
            color: #fff;
        }
        .form-label {
            font-weight: 500;
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        .input-group-text-toggle {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-left: none;
            color: #9ca3af;
            cursor: pointer;
            border-radius: 0 0.75rem 0.75rem 0;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            transition: color 0.2s;
        }
        .input-group-text-toggle:hover {
            color: #f3f4f6;
        }
        a {
            color: #818cf8;
            text-decoration: none;
            transition: color 0.15s ease-in-out;
        }
        a:hover {
            color: #a5b4fc;
        }
        .alert {
            border-radius: 0.75rem;
            border: none;
        }
        .text-muted {
            color: #94a3b8 !important;
        }
        .small.text-muted {
            color: #cbd5e1 !important;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            
            {{-- Left Section (Visual Area) --}}
            <div class="col-lg-6 left-visual-section d-none d-lg-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="position-relative z-1 my-auto" style="max-width: 500px;">
                    <a href="/" class="auth-logo mb-3 d-inline-block">
                        <i class="bi bi-shield-lock-fill me-2"></i>{{ config('app.name', 'SaaSStater') }}
                    </a>
                    <h2 class="fw-bold text-white mb-2">Enterprise SaaS Blueprint</h2>
                    <p class="text-muted mb-4 small">Launch faster with dynamic schema modules, robust authentication logs, active user status controls, and seamless multi-tenant isolation layers.</p>
                    
                    <div class="d-flex flex-column gap-2 align-items-start text-start mx-auto" style="max-width: 380px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <span class="small text-muted">Dynamic Module Builder & Scaffold engine</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded bg-success bg-opacity-10 text-success">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="small text-muted">Secure user portal with Audit logging</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded bg-info bg-opacity-10 text-info">
                                <i class="bi bi-palette"></i>
                            </div>
                            <span class="small text-muted">Obsidian, Cyber, Astral, and Minimal themes</span>
                        </div>
                    </div>
                </div>

                @hasSection('left-bottom')
                    <div class="w-100 position-relative z-1 mt-auto pt-3" style="max-width: 400px;">
                        @yield('left-bottom')
                    </div>
                @endif
            </div>

            {{-- Right Section (Form Area) --}}
            <div class="col-lg-6 right-form-section">
                <div class="auth-card">
                    <div class="text-center d-lg-none mb-4">
                        <a href="/" class="auth-logo">
                            <i class="bi bi-shield-lock-fill me-2"></i>{{ config('app.name', 'SaaSStater') }}
                        </a>
                    </div>
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password Visibility Toggle Utility
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.password-toggle-btn');
            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
