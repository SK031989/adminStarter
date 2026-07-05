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
            --bg-color: #faf5ff;
            --text-color: #2e1065;
            --navbar-bg: rgba(219, 70, 239, 0.05);
            --navbar-border: rgba(219, 70, 239, 0.2);
            --card-bg: rgba(255, 255, 255, 0.7);
            --card-border: rgba(219, 70, 239, 0.2);
            --card-shadow: 0 8px 32px 0 rgba(219, 70, 239, 0.05);
            --btn-outline-color: #2e1065;
            --footer-bg: #f3e8ff;
            --footer-border: rgba(219, 70, 239, 0.2);
            --text-muted-color: #6b21a8;
            --nav-link-active: #c026d3;
        }
        .dark {
            --bg-color: #090514;
            --text-color: #fdf4ff;
            --navbar-bg: rgba(219, 70, 239, 0.05);
            --navbar-border: rgba(219, 70, 239, 0.15);
            --card-bg: rgba(22, 14, 42, 0.4);
            --card-border: rgba(219, 70, 239, 0.15);
            --card-shadow: 0 8px 32px 0 rgba(219, 70, 239, 0.05);
            --btn-outline-color: #fdf4ff;
            --footer-bg: #160e2a;
            --footer-border: rgba(219, 70, 239, 0.15);
            --text-muted-color: #c084fc;
            --nav-link-active: #d946ef;
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
            backdrop-filter: blur(16px);
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
            backdrop-filter: blur(12px);
            border: 1px solid var(--card-border);
            border-radius: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: #d946ef;
            transform: scale(1.02);
        }
        .btn-mkt-primary {
            background: linear-gradient(135deg, #d946ef 0%, #6366f1 100%);
            border: none;
            color: #fff !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 1rem;
        }
        .btn-mkt-primary:hover {
            box-shadow: 0 0 20px rgba(219, 70, 239, 0.4);
        }
        .btn-mkt-outline {
            border: 1px solid var(--card-border);
            background: transparent;
            color: var(--btn-outline-color);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 1rem;
        }
        .btn-mkt-outline:hover {
            border-color: #d946ef;
            background: rgba(219, 70, 239, 0.05);
            color: #d946ef !important;
        }
        footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--footer-border);
            color: var(--text-muted-color);
            transition: background 0.3s ease;
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
    @include('themes.astral.partials.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.astral.partials.footer')
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
