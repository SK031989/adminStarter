<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketing') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f0fdfa;
            --text-color: #0f172a;
            --navbar-bg: #ccfbf1;
            --navbar-border: #0d9488;
            --card-bg: #ccfbf1;
            --card-border: #99f6e4;
            --card-shadow: 0 0 10px rgba(13, 148, 136, 0.1);
            --btn-outline-color: #0f172a;
            --footer-bg: #e0f2fe;
            --footer-border: #99f6e4;
            --text-muted-color: #0d9488;
            --cyan-neon: #0d9488;
            --btn-primary-bg: #0d9488;
            --btn-primary-text: #ffffff;
        }
        .dark {
            --bg-color: #020617;
            --text-color: #e2e8f0;
            --navbar-bg: #0b1329;
            --navbar-border: #06b6d4;
            --card-bg: #0b1329;
            --card-border: #1e293b;
            --card-shadow: 0 0 10px rgba(6, 182, 212, 0.1);
            --btn-outline-color: #e2e8f0;
            --footer-bg: #020617;
            --footer-border: #1e293b;
            --text-muted-color: #64748b;
            --cyan-neon: #06b6d4;
            --btn-primary-bg: #06b6d4;
            --btn-primary-text: #020617;
        }
        body {
            font-family: 'Courier Prime', monospace;
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
            border-bottom: 2px solid var(--navbar-border);
        }
        .nav-link-mkt {
            color: var(--text-color) !important;
            font-weight: 700;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: var(--cyan-neon) !important;
        }
        .mkt-card {
            background: var(--card-bg);
            border: 2px solid var(--card-border);
            border-radius: 0;
            box-shadow: var(--card-shadow);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: var(--cyan-neon);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.3);
        }
        .btn-mkt-primary {
            background: var(--btn-primary-bg);
            border: none;
            color: var(--btn-primary-text) !important;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 0;
        }
        .btn-mkt-primary:hover {
            background: var(--btn-primary-bg);
            filter: brightness(1.2);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.5);
        }
        .btn-mkt-outline {
            border: 2px solid var(--card-border);
            background: transparent;
            color: var(--btn-outline-color);
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 0;
        }
        .btn-mkt-outline:hover {
            border-color: var(--cyan-neon);
            color: var(--cyan-neon) !important;
        }
        footer {
            background: var(--footer-bg);
            border-top: 2px solid var(--footer-border);
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
    @include('themes.cyber.partials.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.cyber.partials.footer')
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
