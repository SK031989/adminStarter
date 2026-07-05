<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('app.name', 'SaaS Starter') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons via CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- ApexCharts via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Bootstrap CSS (kept for backward compatibility with nested module pages) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Tailwind CSS (Vite compiled) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Inline Theme script to prevent flash -->
    <script>
        (function() {
            const theme = localStorage.getItem('admin-theme') || 'light';
            const isDark = theme === 'dark';
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        main {
            padding-top: 5rem !important;
        }
        /* Custom slide-out and transitions for sidebar collapse */
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Override Bootstrap conflicts */
        a {
            text-decoration: none !important;
        }
        .btn:focus, .form-control:focus, .form-select:focus {
            box-shadow: none !important;
        }
        kbd {
            color: #64748b !important;
            background-color: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.05) !important;
            padding: 0.125rem 0.375rem !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            font-family: inherit !important;
            border-radius: 0.25rem !important;
        }
        .dark kbd {
            color: #94a3b8 !important;
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
        }
        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
        /* Active menu highlight with purple gradient */
        .active-menu-item {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.35);
            color: #ffffff !important;
        }
        /* Sidebar light mode nav hover */
        .sidebar-nav-hover:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .dark .sidebar-nav-hover:hover {
            background-color: rgba(30, 41, 59, 0.4);
            color: #f1f5f9;
        }
        /* Sidebar dark gradient (applied via JS on dark mode) */
        .dark #sidebar {
            background: linear-gradient(to bottom, #0b0f19, #0f172a, #141235) !important;
            border-color: rgb(30 41 59) !important;
            color: rgb(203 213 225) !important;
        }
        .dark #sidebar .logo-container {
            border-bottom-color: rgba(30, 41, 59, 0.6) !important;
        }
        /* Collapsed sidebar structural changes */
        body.sidebar-collapsed #sidebar {
            width: 5rem;
        }
        body.sidebar-collapsed #sidebar .logo-full-text,
        body.sidebar-collapsed #sidebar .nav-label-text,
        body.sidebar-collapsed #sidebar .theme-label-text,
        body.sidebar-collapsed #sidebar .profile-details,
        body.sidebar-collapsed #sidebar .profile-chevron {
            display: none;
        }
        body.sidebar-collapsed #sidebar .logo-container {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category {
            text-align: center;
            font-size: 0.65rem;
            padding: 0.5rem 0;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category::after {
            content: "⋯";
            display: block;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category-text {
            display: none;
        }
        body.sidebar-collapsed #sidebar .nav-link-item {
            justify-content: center;
            padding: 0.75rem 0;
        }
        body.sidebar-collapsed #sidebar .theme-selector-wrapper {
            flex-direction: column;
            gap: 0.5rem;
            padding: 0.5rem 0.25rem;
        }
        body.sidebar-collapsed #sidebar .theme-radio-btn {
            padding: 0.5rem;
        }
        body.sidebar-collapsed #sidebar .profile-wrapper {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        body.sidebar-collapsed #main-content-area {
            margin-left: 5rem;
        }
        /* Floating Dropdown states */
        .dropdown-animate {
            transform-origin: top right;
            transition: opacity 0.15s ease-out, transform 0.15s ease-out;
        }
        .hidden-dropdown {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }
        body.sidebar-collapsed header {
            left: 5rem !important;
        }
        #sidebar-profile-dropdown {
            left: 1rem !important;
            right: 1rem !important;
            width: auto !important;
        }
        body.sidebar-collapsed #sidebar-profile-dropdown {
            left: 5.5rem !important;
            right: auto !important;
            width: 14rem !important;
            bottom: 0px !important;
            margin-bottom: 0 !important;
        }
        
        /* Sun/moon icon visibility inside toggle button */
        #theme-toggle-btn .sun-icon {
            display: none;
        }
        #theme-toggle-btn .moon-icon {
            display: block;
        }
        .dark #theme-toggle-btn .sun-icon {
            display: block;
        }
        .dark #theme-toggle-btn .moon-icon {
            display: none;
        }
        
        /* Dark mode overrides for full dashboard sections */
        .dark body {
            background-color: #0b0f19 !important;
            color: #cbd5e1 !important;
        }
        .dark header {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark #main-content-area {
            background-color: #0b0f19 !important;
        }
        .dark .bg-white {
            background-color: #0f172a !important;
        }
        .dark .bg-slate-50 {
            background-color: #0b0f19 !important;
        }
        .dark .bg-slate-100 {
            background-color: #1e293b !important;
        }
        .dark .bg-slate-100\/70 {
            background-color: rgba(30, 41, 59, 0.7) !important;
        }
        .dark .border-slate-200 {
            border-color: #1e293b !important;
        }
        .dark .text-slate-900 {
            color: #ffffff !important;
        }
        .dark .text-slate-800 {
            color: #e2e8f0 !important;
        }
        .dark .text-slate-700 {
            color: #cbd5e1 !important;
        }
        .dark .text-slate-650 {
            color: #cbd5e1 !important;
        }
        .dark .text-slate-600 {
            color: #94a3b8 !important;
        }
        .dark .text-slate-500 {
            color: #94a3b8 !important;
        }
        .dark .border-slate-100 {
            border-color: #1e293b !important;
        }
        .dark .hover\:bg-slate-50:hover {
            background-color: #1e293b !important;
        }
        .dark .bg-slate-50:hover {
            background-color: #1e293b !important;
        }
        .dark input {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark hr {
            border-color: #1e293b !important;
        }
        .dark .dropdown-animate {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark .dropdown-animate a {
            color: #cbd5e1 !important;
        }
        .dark .dropdown-animate a:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .search-result-item {
            color: #cbd5e1 !important;
        }
        .dark .search-result-item:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark #search-modal > div {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        
        /* Bootstrap dark mode overrides for Module Builder components */
        .dark .card {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #1e293b !important;
        }
        .dark .card-body {
            color: #e2e8f0 !important;
        }
        .dark .text-muted {
            color: #94a3b8 !important;
        }
        .dark .table {
            --bs-table-color: #cbd5e1 !important;
            --bs-table-bg: transparent !important;
            --bs-table-border-color: #1e293b !important;
            --bs-table-hover-color: #ffffff !important;
            --bs-table-hover-bg: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .dark .table th, .dark .table td {
            background-color: transparent !important;
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }
        .dark .table-hover tbody tr:hover td {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .list-group-item {
            background-color: #0f172a !important;
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }
        .dark .form-control, .dark .form-select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark .form-control::placeholder {
            color: #64748b !important;
        }
        .dark .form-control:focus, .dark .form-select:focus {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border-color: #a855f7 !important;
            box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.25) !important;
        }
        .dark .btn-close {
            filter: invert(1) grayscale(1) brightness(2) !important;
        }
        .dark .alert {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        .dark .modal-content {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .modal-header, .dark .modal-footer {
            border-color: #1e293b !important;
        }
        
        /* Dark mode overrides for card icon badges in Module Builder */
        .dark .bg-primary.bg-opacity-10 {
            background-color: rgba(99, 102, 241, 0.2) !important;
        }
        .dark .bg-primary.bg-opacity-10 i {
            color: #818cf8 !important;
        }
        .dark .bg-success.bg-opacity-10 {
            background-color: rgba(16, 185, 129, 0.2) !important;
        }
        .dark .bg-success.bg-opacity-10 i {
            color: #34d399 !important;
        }
        .dark .bg-warning.bg-opacity-10 {
            background-color: rgba(245, 158, 11, 0.2) !important;
        }
        .dark .bg-warning.bg-opacity-10 i {
            color: #fbbf24 !important;
        }
        .dark .bg-secondary.bg-opacity-10 {
            background-color: rgba(148, 163, 184, 0.2) !important;
        }
        .dark .bg-secondary.bg-opacity-10 i {
            color: #cbd5e1 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200 antialiased overflow-x-hidden">

        @include('dashboard::layouts.partials.sidebar')

    <!-- Mobile Sidebar Backdrop -->
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm hidden md:hidden"></div>

    <div class="flex min-h-screen">

        <!-- ========================================== -->
        <!-- MAIN CONTENT AREA                          -->
        <!-- ========================================== -->
        <div id="main-content-area" class="sidebar-transition flex-1 flex flex-col md:ml-64 min-w-0 h-screen overflow-hidden">
            
            @include('dashboard::layouts.partials.header')


            <!-- PAGE CONTENT ROUTER -->
            <main class="flex-1 overflow-y-auto pt-16 px-6 md:px-8 pb-8">
                <!-- Session Alert Messages -->
                @if(session('success'))
                    <div class="mt-6 mb-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/60 text-emerald-800 dark:text-emerald-300 flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mt-6 mb-4 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/60 text-rose-800 dark:text-rose-300 flex items-center gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-500"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('dashboard::layouts.partials.footer')

        </div>
    </div>

    <!-- ========================================== -->
    <!-- SEARCH PANEL DRAWER MODAL                  -->
    <!-- ========================================== -->
    <div id="search-modal" class="fixed inset-0 z-50 flex items-start justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="w-full max-w-xl mt-16 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center gap-3 px-4 py-3 border-b border-slate-200 dark:border-slate-800">
                <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                <input type="text" id="search-input" placeholder="Search menus, features, orders or logs..." class="w-full bg-transparent border-0 outline-none text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                <button id="search-close-btn" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-400 dark:text-slate-500 transition">
                    <kbd>ESC</kbd>
                </button>
            </div>
            <div class="max-h-96 overflow-y-auto p-4 space-y-4">
                <div class="space-y-1.5">
                    <span class="text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Quick Actions</span>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-500"></i>
                        <span>Go to Dashboard</span>
                    </a>
                    <a href="{{ route('module-builder.index') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="cpu" class="w-4 h-4 text-indigo-500"></i>
                        <span>Open Module Builder</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="settings" class="w-4 h-4 text-slate-500"></i>
                        <span>System Configuration</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Global Application Interactive Script -->
    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // ----------------------------------------------------
        // Dropdown Utility Handler
        // ----------------------------------------------------
        function setupDropdown(triggerId, dropdownId) {
            const trigger = document.getElementById(triggerId);
            const dropdown = document.getElementById(dropdownId);
            if (!trigger || !dropdown) return;

            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-animate').forEach(d => {
                    if (d !== dropdown) {
                        d.classList.add('hidden-dropdown');
                    }
                });
                dropdown.classList.toggle('hidden-dropdown');
            });
        }

        setupDropdown('sidebar-profile-btn', 'sidebar-profile-dropdown');
        setupDropdown('message-btn', 'message-dropdown');
        setupDropdown('notification-btn', 'notification-dropdown');
        setupDropdown('topbar-avatar-btn', 'topbar-avatar-dropdown');

        // Close dropdowns on document click
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-animate').forEach(d => {
                d.classList.add('hidden-dropdown');
            });
        });

        // Prevent closing when clicking inside the dropdown panel itself
        document.querySelectorAll('.dropdown-animate').forEach(dropdown => {
            dropdown.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

        // ----------------------------------------------------
        // Sidebar Toggling & Collapsing
        // ----------------------------------------------------
        const body = document.body;
        const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
        const mobileBackdrop = document.getElementById('mobile-sidebar-backdrop');
        const sidebar = document.getElementById('sidebar');

        // Load Sidebar state from LocalStorage
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            body.classList.add('sidebar-collapsed');
        }

        function toggleSidebar() {
            body.classList.toggle('sidebar-collapsed');
            const isCollapsed = body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        }

        // Mobile drawer slide-in / Desktop collapse
        if (mobileToggleBtn) {
            mobileToggleBtn.addEventListener('click', () => {
                if (window.innerWidth >= 768) {
                    toggleSidebar();
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    mobileBackdrop.classList.remove('hidden');
                }
            });
        }

        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileBackdrop.classList.add('hidden');
            });
        }

        // ----------------------------------------------------
        // Dynamic Command Palette / Search Modal
        // ----------------------------------------------------
        const searchTrigger = document.getElementById('search-trigger-btn');
        const searchTriggerMobile = document.getElementById('search-trigger-mobile');
        const searchModal = document.getElementById('search-modal');
        const searchClose = document.getElementById('search-close-btn');
        const searchInput = document.getElementById('search-input');
        const searchResultsContainer = document.querySelector('#search-modal .max-h-96');

        window.setSelectedIndex = function(index) {
            selectedIndex = index;
            const items = searchResultsContainer.querySelectorAll('.search-result-item');
            items.forEach((item) => {
                const itemIndex = parseInt(item.getAttribute('data-index'), 10);
                const isSelected = itemIndex === selectedIndex;
                
                if (isSelected) {
                    item.classList.remove('hover:bg-slate-50', 'dark:hover:bg-slate-850/50', 'text-slate-700', 'dark:text-slate-300');
                    item.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'ring-1', 'ring-purple-500/20');
                    
                    const chevron = item.querySelector('[data-lucide="chevron-right"]');
                    if (chevron) {
                        chevron.classList.remove('opacity-0');
                        chevron.classList.add('opacity-100');
                    }
                } else {
                    item.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'ring-1', 'ring-purple-500/20');
                    item.classList.add('hover:bg-slate-50', 'dark:hover:bg-slate-850/50', 'text-slate-700', 'dark:text-slate-300');
                    
                    const chevron = item.querySelector('[data-lucide="chevron-right"]');
                    if (chevron) {
                        chevron.classList.remove('opacity-100');
                        chevron.classList.add('opacity-0');
                    }
                }
            });
        };

        // All searchable items index
        const searchIndex = [
            { name: 'Dashboard', path: "{{ route('admin.dashboard') }}", category: 'Pages', icon: 'layout-dashboard', color: 'text-purple-500' },
            { name: 'Users', path: "{{ route('admin.users.index') }}", category: 'Management', icon: 'users', color: 'text-teal-500' },
            { name: 'Projects', path: '#', category: 'Management', icon: 'folder-kanban', color: 'text-orange-500' },
            { name: 'Tasks', path: '#', category: 'Management', icon: 'check-square', color: 'text-red-500' },
            { name: 'Orders', path: '#', category: 'Management', icon: 'shopping-cart', color: 'text-emerald-500' },
            { name: 'Products', path: '#', category: 'Management', icon: 'package', color: 'text-indigo-500' },
            { name: 'Module Builder', path: "{{ route('module-builder.index') }}", category: 'System', icon: 'cpu', color: 'text-pink-500' },
            { name: 'Roles & Permissions', path: "{{ route('admin.roles.index') }}", category: 'System', icon: 'shield', color: 'text-rose-500' },
            { name: 'Configuration', path: "{{ route('admin.settings') }}", category: 'System', icon: 'settings', color: 'text-slate-500' },
            { name: 'My Profile', path: "{{ route('admin.profile.edit') }}", category: 'Account', icon: 'user', color: 'text-sky-500' },
            { name: 'Account Settings', path: "{{ route('admin.profile.edit') }}", category: 'Account', icon: 'settings', color: 'text-purple-500' }
        ];

        let selectedIndex = 0;
        let filteredItems = [];

        function renderResults(query = '') {
            filteredItems = searchIndex.filter(item => 
                item.name.toLowerCase().includes(query.toLowerCase()) || 
                item.category.toLowerCase().includes(query.toLowerCase())
            );

            if (filteredItems.length === 0) {
                searchResultsContainer.innerHTML = `
                    <div class="text-center py-8 text-slate-400 dark:text-slate-500 text-sm">
                        <i data-lucide="info" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        No results found for "${query}"
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            // Group by category
            const groups = {};
            filteredItems.forEach((item, index) => {
                const globalIndex = index;
                if (!groups[item.category]) {
                    groups[item.category] = [];
                }
                groups[item.category].push({ ...item, globalIndex });
            });

            let html = '';
            for (const category in groups) {
                html += `
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase px-2">${category}</span>
                        <div class="space-y-0.5">
                `;
                groups[category].forEach(item => {
                    const isSelected = item.globalIndex === selectedIndex;
                    const activeClasses = isSelected 
                        ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white ring-1 ring-purple-500/20' 
                        : 'hover:bg-slate-50 dark:hover:bg-slate-850/50 text-slate-700 dark:text-slate-300';
                    
                    html += `
                        <a href="${item.path}" class="search-result-item flex items-center justify-between p-2.5 rounded-xl text-sm font-medium transition duration-100 no-underline ${activeClasses}" data-index="${item.globalIndex}" onmouseenter="setSelectedIndex(${item.globalIndex})">
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                    <i data-lucide="${item.icon}" class="w-4 h-4 ${item.color}"></i>
                                </div>
                                <span>${item.name}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 transition-opacity duration-100 ${isSelected ? 'opacity-100 text-slate-400' : 'opacity-0'}"></i>
                        </a>
                    `;
                });
                html += `
                        </div>
                    </div>
                `;
            }

            searchResultsContainer.innerHTML = html;
            lucide.createIcons();
        }

        function openSearch() {
            if (searchModal) {
                searchModal.classList.remove('hidden');
                searchInput.value = '';
                selectedIndex = 0;
                renderResults('');
                setTimeout(() => searchInput.focus(), 50);
            }
        }

        function closeSearch() {
            if (searchModal) {
                searchModal.classList.add('hidden');
            }
        }

        if (searchTrigger) searchTrigger.addEventListener('click', openSearch);
        if (searchTriggerMobile) searchTriggerMobile.addEventListener('click', openSearch);
        if (searchClose) searchClose.addEventListener('click', closeSearch);

        // Click backdrop to close search
        if (searchModal) {
            searchModal.addEventListener('click', (e) => {
                if (e.target === searchModal) {
                    closeSearch();
                }
            });
        }

        searchInput.addEventListener('input', (e) => {
            selectedIndex = 0;
            renderResults(e.target.value);
        });

        window.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
            if (e.key === 'Escape') {
                closeSearch();
            }

            if (!searchModal.classList.contains('hidden')) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (filteredItems.length > 0) {
                        selectedIndex = (selectedIndex + 1) % filteredItems.length;
                        setSelectedIndex(selectedIndex);
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (filteredItems.length > 0) {
                        selectedIndex = (selectedIndex - 1 + filteredItems.length) % filteredItems.length;
                        setSelectedIndex(selectedIndex);
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (filteredItems[selectedIndex]) {
                        window.location.href = filteredItems[selectedIndex].path;
                    }
                }
            }
        });

        // ----------------------------------------------------
        // Theme Management Script
        // ----------------------------------------------------
        const themeToggleBtn = document.getElementById('theme-toggle-btn');

        function setTheme(theme) {
            localStorage.setItem('admin-theme', theme);
            const isDark = theme === 'dark';

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Dispatch dynamic window event for child frames/charts to adapt
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme, isDark } }));
        }

        // Init theme from localStorage (default: light)
        const activeTheme = localStorage.getItem('admin-theme') || 'light';
        setTheme(activeTheme);

        window.toggleTheme = function() {
            const currentTheme = localStorage.getItem('admin-theme') || 'light';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(nextTheme);
        };
    </script>
    @stack('scripts')
</body>
</html>
