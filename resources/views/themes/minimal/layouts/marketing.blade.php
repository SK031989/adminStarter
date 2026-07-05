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
            --bg-color: #f8fafc;
            --text-color: #0f172a;
            --navbar-bg: #ffffff;
            --navbar-border: #e2e8f0;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            --btn-outline-color: #0f172a;
            --footer-bg: #ffffff;
            --footer-border: #e2e8f0;
            --text-muted-color: #475569;
            --btn-primary-bg: #0f172a;
            --btn-primary-text: #ffffff;
            --nav-link-active: #2563eb;
        }
        .dark {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --navbar-bg: #1e293b;
            --navbar-border: #334155;
            --card-bg: #1e293b;
            --card-border: #334155;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            --btn-outline-color: #f8fafc;
            --footer-bg: #1e293b;
            --footer-border: #334155;
            --text-muted-color: #cbd5e1;
            --btn-primary-bg: #f8fafc;
            --btn-primary-text: #0f172a;
            --nav-link-active: #60a5fa;
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
            border: 1px solid var(--card-border);
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
        }
        .btn-mkt-primary {
            background: var(--btn-primary-bg);
            border: none;
            color: var(--btn-primary-text) !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
        }
        .btn-mkt-primary:hover {
            background: var(--btn-primary-bg);
            filter: brightness(1.2);
        }
        .btn-mkt-outline {
            border: 1px solid var(--card-border);
            background: transparent;
            color: var(--btn-outline-color);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
        }
        .btn-mkt-outline:hover {
            background: rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }
        .dark .btn-mkt-outline:hover {
            background: rgba(255, 255, 255, 0.05);
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
            const mode = localStorage.getItem('marketing-mode') || 'light';
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
    @include('themes.minimal.partials.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.minimal.partials.footer')
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
            const currentMode = localStorage.getItem('marketing-mode') || 'light';
            const nextMode = currentMode === 'dark' ? 'light' : 'dark';
            setMode(nextMode);
        };

        // Init UI
        const activeMode = localStorage.getItem('marketing-mode') || 'light';
        updateModeUI(activeMode);
    </script>
</body>
</html>
