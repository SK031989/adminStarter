{{-- ============================================ --}}
{{-- SIDEBAR PARTIAL                              --}}
{{-- Include in layout: @include('dashboard::layouts.partials.sidebar') --}}
{{-- ============================================ --}}

@php
    $isSuperAdmin = auth()->check() && auth()->user()->is_admin;
    $isAdminUser = auth()->check() && (auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin'));
@endphp

<!-- Fixed Left Sidebar -->
<aside id="sidebar" class="sidebar-transition fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200 text-slate-700 flex flex-col -translate-x-full md:translate-x-0">

    <!-- Brand logo area -->
    <div class="logo-container h-16 flex items-center justify-between px-6 border-b border-slate-200 dark:border-slate-800/60 shrink-0">
        <a href="{{ $isAdminUser ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-3 no-underline">
            <div class="p-2 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 shadow-md">
                <i data-lucide="{{ config('settings.project_logo', 'shield') }}" class="w-5 h-5 text-white"></i>
            </div>
            <span class="logo-full-text font-bold text-lg tracking-tight text-slate-900 dark:text-white">{{ config('app.name', 'SaaSStater') }}</span>
        </a>
    </div>

    <!-- Navigation List -->
    <nav class="flex-grow px-4 py-6 space-y-7 overflow-y-auto shrink min-h-0">
        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Core Dashboard</span>
            </div>

            <!-- Dashboard -->
            <a href="{{ $isAdminUser ? route('admin.dashboard') : route('dashboard') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ (request()->routeIs('admin.dashboard') || request()->routeIs('dashboard')) ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Dashboard</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Management</span>
            </div>

            <!-- Users -->
            @if($isSuperAdmin)
            <a href="{{ route('admin.users.index') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.users.index') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Users</span>
            </a>
            @endif

            {{-- Dynamically list generated modules --}}
            @if(class_exists('\Modules\ModuleBuilder\App\Models\DynamicModule'))
                @php
                    $sidebarModules = \Modules\ModuleBuilder\App\Models\DynamicModule::active()->generated()->orderBy('sort_order')->get();
                @endphp
                @foreach($sidebarModules as $sModule)
                    @php
                        $baseRouteName = Route::has($sModule->slug . '.index') 
                            ? $sModule->slug . '.index' 
                            : (Route::has(\Illuminate\Support\Str::plural($sModule->slug) . '.index') 
                                ? \Illuminate\Support\Str::plural($sModule->slug) . '.index' 
                                : null);

                        if ($isAdminUser && $baseRouteName) {
                            $adminRouteName = 'admin.' . $baseRouteName;
                            $moduleRouteName = Route::has($adminRouteName) ? $adminRouteName : $baseRouteName;
                        } else {
                            $moduleRouteName = $baseRouteName;
                        }
                        
                        $isActive = $moduleRouteName ? (
                            request()->routeIs($sModule->slug . '.*') || 
                            request()->routeIs(\Illuminate\Support\Str::plural($sModule->slug) . '.*') ||
                            request()->routeIs('admin.' . $sModule->slug . '.*') || 
                            request()->routeIs('admin.' . \Illuminate\Support\Str::plural($sModule->slug) . '.*')
                        ) : false;
                        
                        // Map Bootstrap Icons classes to Lucide icons where possible, fallback to layout-grid
                        $lucideIcon = 'layout-grid';
                        if ($sModule->icon) {
                            $iconName = str_replace('bi-', '', $sModule->icon);
                            // Mapping common ones
                            if ($iconName === 'box-seam' || $iconName === 'box') {
                                $lucideIcon = 'package';
                            } elseif ($iconName === 'people' || $iconName === 'person') {
                                $lucideIcon = 'users';
                            } elseif ($iconName === 'folder' || $iconName === 'folder-fill') {
                                $lucideIcon = 'folder';
                            } elseif ($iconName === 'receipt') {
                                $lucideIcon = 'receipt';
                            } else {
                                $lucideIcon = $iconName;
                            }
                        }
                    @endphp
                    @if($moduleRouteName && ($isAdminUser || auth()->user()->can($sModule->slug . '.view') || auth()->user()->can(\Illuminate\Support\Str::plural($sModule->slug) . '.view')))
                        <a href="{{ route($moduleRouteName) }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ $isActive ? 'active-menu-item !text-white' : '' }}">
                            <i data-lucide="{{ $lucideIcon }}" class="w-5 h-5 shrink-0"></i>
                            <span class="nav-label-text">{{ $sModule->name }}</span>
                        </a>
                    @endif
                @endforeach
            @endif
        </div>

        @if($isSuperAdmin)
        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">System</span>
            </div>

            <!-- Module Builder -->
            <a href="{{ route('module-builder.index') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('module-builder.*') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="cpu" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Module Builder</span>
            </a>

            <!-- Roles & Permissions -->
            <a href="{{ route('admin.roles.index') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.roles.*') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="shield" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Roles & Permissions</span>
            </a>

            <!-- Configuration -->
            <a href="{{ route('admin.settings') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.settings') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Configuration</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- Sidebar Bottom: User Profile Area -->
    <div class="border-t border-slate-200 dark:border-slate-800 shrink-0">
        <div class="relative">
            <button id="sidebar-profile-btn" class="profile-wrapper w-full h-16 flex items-center justify-between px-6 hover:bg-slate-100 dark:hover:bg-slate-800/40 transition text-left">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&background=6366f1&color=fff" alt="Avatar" class="accent-avatar w-9 h-9 rounded-xl shadow-inner border border-slate-200 dark:border-slate-700">
                    <div class="profile-details">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white truncate max-w-[120px]">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500 font-medium truncate max-w-[120px]">{{ auth()->user()->roles->first()?->name ?? (auth()->user()->is_admin ? 'Super Admin' : 'User') }}</div>
                    </div>
                </div>
                <i data-lucide="chevron-up" class="profile-chevron w-4 h-4 text-slate-400"></i>
            </button>

            <!-- Sidebar Profile Dropdown -->
            <div id="sidebar-profile-dropdown" class="dropdown-animate hidden-dropdown absolute bottom-full left-0 right-0 z-50 mb-2 bg-white dark:bg-[#0f172a] border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl p-2 space-y-1">
                <a href="{{ $isAdminUser ? route('admin.profile.edit') : route('auth.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg no-underline transition animate-none">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ $isAdminUser ? route('admin.profile.edit') : route('auth.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg no-underline transition">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Account Settings</span>
                </a>
                <hr class="border-slate-200 dark:border-slate-800 my-1">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition text-left">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</aside>
