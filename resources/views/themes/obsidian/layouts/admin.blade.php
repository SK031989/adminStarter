<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0b0f19;
            color: #f3f4f6;
            min-height: 100vh;
        }
        .sidebar {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            min-height: 100vh;
        }
        .main-content {
            padding: 2.5rem;
        }
        .glass-card {
            background: rgba(31, 41, 55, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }
        .stat-icon {
            padding: 1rem;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border-radius: 0.75rem;
            font-size: 1.5rem;
            display: inline-flex;
        }
        .nav-sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #9ca3af;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-sidebar-link:hover, .nav-sidebar-link.active {
            background: rgba(99, 102, 241, 0.1);
            color: #818cf8;
        }
        .table-dark-custom {
            --bs-table-bg: transparent;
            color: #e5e7eb;
            border-color: rgba(255, 255, 255, 0.08);
        }
        /* Style fixes for bootstrap default inputs on dark theme */
        .form-control, .form-select {
            background-color: rgba(31, 41, 55, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }
        .form-control::placeholder {
            color: #6b7280 !important;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
            border-color: #6366f1 !important;
        }
        .table {
            color: #e5e7eb !important;
        }
        .list-group-item {
            background-color: rgba(31, 41, 55, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            
            {{-- Unified Sidebar --}}
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
                <div class="d-flex align-items-center gap-2 mb-4 px-2">
                    <i class="bi bi-shield-fill-check text-primary fs-3"></i>
                    <span class="fs-5 fw-bold text-white">SaaS Console</span>
                </div>
                
                <hr class="border-secondary opacity-25">

                <div class="d-flex flex-column gap-2 mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="nav-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('module-builder.index') }}" class="nav-sidebar-link {{ request()->routeIs('module-builder.*') ? 'active' : '' }}">
                        <i class="bi bi-tools"></i>
                        <span>Module Builder</span>
                    </a>

                    <a href="{{ route('marketing.index') }}" class="nav-sidebar-link">
                        <i class="bi bi-globe"></i>
                        <span>Marketing Home</span>
                    </a>
                    
                    {{-- Dynamically list generated modules if model class exists --}}
                    @if(class_exists('\Modules\ModuleBuilder\App\Models\DynamicModule'))
                        @php
                            $sidebarModules = \Modules\ModuleBuilder\App\Models\DynamicModule::active()->generated()->orderBy('sort_order')->take(10)->get();
                        @endphp
                        @if($sidebarModules->isNotEmpty())
                            <hr class="border-secondary opacity-25">
                            <small class="text-muted px-2 py-1 d-block">ACTIVE MODULES</small>
                            @foreach($sidebarModules as $sModule)
                                <a href="{{ route('module-builder.show', $sModule) }}" class="nav-sidebar-link">
                                    <i class="bi {{ $sModule->icon ?? 'bi-circle' }}"></i>
                                    <span>{{ $sModule->name }}</span>
                                </a>
                            @endforeach
                        @endif
                    @endif

                    <div class="mt-5">
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 0.5rem;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            {{-- Page Content wrapper --}}
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                
                {{-- Header greeting --}}
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h1 class="h3 fw-bold text-white mb-1">@yield('title', 'Admin Dashboard')</h1>
                        <p class="text-muted small mb-0">Management panel & system settings.</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-bold">Tenant #{{ auth()->user()->tenant_id ?? 1 }}</span>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-bold">ONLINE</span>
                    </div>
                </div>

                @yield('content')

            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
