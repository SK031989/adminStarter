<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketing') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f3f4f6;
            --text-color: #0b0f19;
            --navbar-bg: rgba(255, 255, 255, 0.8);
            --navbar-border: rgba(0, 0, 0, 0.08);
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(0, 0, 0, 0.08);
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            --btn-outline-color: #0b0f19;
            --footer-bg: #e5e7eb;
            --footer-border: rgba(0, 0, 0, 0.08);
            --text-muted-color: #4b5563;
            --nav-link-active: #4f46e5;
        }
        .dark {
            --bg-color: #0b0f19;
            --text-color: #f3f4f6;
            --navbar-bg: rgba(99, 102, 241, 0.03);
            --navbar-border: rgba(255, 255, 255, 0.08);
            --card-bg: rgba(31, 41, 55, 0.6);
            --card-border: rgba(255, 255, 255, 0.08);
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            --btn-outline-color: #f3f4f6;
            --footer-bg: #111827;
            --footer-border: rgba(255, 255, 255, 0.08);
            --text-muted-color: #9ca3af;
            --nav-link-active: #818cf8;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background 0.3s ease, color 0.3s ease;
        }
        body .text-white {
            color: var(--text-color) !important;
        }
        body .text-muted {
            color: var(--text-muted-color) !important;
        }
        .navbar-brand {
            color: var(--text-color) !important;
        }
        .navbar-mkt {
            background: var(--navbar-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--navbar-border);
        }
        .nav-link-mkt {
            color: var(--text-color) !important;
            font-weight: 500;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: var(--nav-link-active) !important;
        }
        .mkt-card {
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            transform: translateY(-4px);
        }
        .mkt-glow {
            filter: blur(100px);
            background: linear-gradient(135deg, #6366f1, #a855f7);
            opacity: 0.15;
            position: absolute;
            z-index: -1;
            width: 300px;
            height: 300px;
            border-radius: 50%;
        }
        .btn-mkt-primary {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border: none;
            color: #fff !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
        }
        .btn-mkt-primary:hover {
            box-shadow: 0 8px 20px -4px rgba(99, 102, 241, 0.4);
        }
        .btn-mkt-outline {
            border: 1px solid var(--card-border);
            background: transparent;
            color: var(--btn-outline-color);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
        }
        .btn-mkt-outline:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
            color: #6366f1 !important;
        }
        footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--footer-border);
            color: var(--text-muted-color);
        }
    </style>
    <!-- Inline Theme Mode script to prevent flash -->
    <script>
        (function() {
            const mode = localStorage.getItem('marketing-mode') || 'dark';
            if (mode === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>
</head>
<body>
    <div class="mkt-glow" style="top: 10%; left: -50px;"></div>
    
    @include('themes.obsidian.partials.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.obsidian.partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateModeUI(mode) {
            const isDark = mode === 'dark';
            const sunIcon = document.querySelector('#mode-toggle-btn .sun-icon');
            const moonIcon = document.querySelector('#mode-toggle-btn .moon-icon');
            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                } else {
                    sunIcon.classList.add('d-none');
                    moonIcon.classList.remove('d-none');
                }
            }
        }

        function setMode(mode) {
            localStorage.setItem('marketing-mode', mode);
            if (mode === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
            updateModeUI(mode);
        }

        window.toggleMode = function() {
            const currentMode = localStorage.getItem('marketing-mode') || 'dark';
            const nextMode = currentMode === 'dark' ? 'light' : 'dark';
            setMode(nextMode);
        };

        // Init UI
        const activeMode = localStorage.getItem('marketing-mode') || 'dark';
        updateModeUI(activeMode);
    </script>
</body>
</html>
