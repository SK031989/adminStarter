{{-- ============================================ --}}
{{-- HEADER / TOP BAR PARTIAL                     --}}
{{-- Include in layout: @include('dashboard::layouts.partials.header') --}}
{{-- ============================================ --}}

<header class="h-16 fixed top-0 right-0 left-0 md:left-64 sidebar-transition z-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800/80 flex items-center justify-between px-6 transition-colors duration-200">

    <div class="flex items-center gap-4">
        <!-- Hamburger / Menu Toggle -->
        <button id="mobile-toggle-btn" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-slate-600 dark:text-slate-300 transition">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <!-- Mobile Search Trigger -->
        <button id="search-trigger-mobile" class="flex sm:hidden p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-slate-600 dark:text-slate-300 transition">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>

        <!-- Search Bar -->
        <button id="search-trigger-btn" class="hidden sm:flex items-center gap-3 px-3.5 py-2 w-72 md:w-80 bg-slate-100/70 hover:bg-slate-200/50 dark:bg-slate-900/60 dark:hover:bg-slate-850/80 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-500 dark:text-slate-400 text-sm hover:border-slate-300 dark:hover:border-slate-700 transition-all duration-150 text-left focus:outline-none shadow-xs group">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-slate-500 group-hover:text-slate-500 dark:group-hover:text-slate-300 transition-colors"></i>
            <span class="flex-grow font-medium text-slate-400 dark:text-slate-500">Search files, logs...</span>
            <div class="flex items-center gap-1 shrink-0 opacity-70 group-hover:opacity-100 transition-opacity">
                <kbd>Ctrl</kbd>
                <kbd>K</kbd>
            </div>
        </button>
    </div>

    <div class="flex items-center gap-3">

        <!-- Light / Dark Mode Toggle -->
        <button id="theme-toggle-btn" type="button" onclick="toggleTheme()" title="Toggle Theme"
            class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition flex items-center justify-center">
            <i data-lucide="moon" class="moon-icon w-5 h-5"></i>
            <i data-lucide="sun" class="sun-icon w-5 h-5"></i>
        </button>

        <!-- Messages with Badge -->
        <div class="relative">
            <button id="message-btn" class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-gradient-to-tr from-purple-500 to-indigo-600 border border-white dark:border-slate-900 rounded-full animate-pulse"></span>
            </button>

            <!-- Messages Dropdown -->
            <div id="message-dropdown" class="dropdown-animate hidden-dropdown absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <h6 class="font-bold text-sm text-slate-900 dark:text-white">Recent Messages</h6>
                    <span class="text-xs text-purple-600 font-semibold cursor-pointer">Mark all read</span>
                </div>
                <hr class="border-slate-100 dark:border-slate-800 my-0">
                <div class="space-y-2">
                    <div class="flex items-start gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl cursor-pointer transition">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Connor&background=c084fc&color=fff" class="w-9 h-9 rounded-xl">
                        <div class="flex-grow">
                            <div class="text-xs font-semibold text-slate-900 dark:text-white">Sarah Connor</div>
                            <div class="text-[11px] text-slate-500 line-clamp-1">Invoice dispute resolved for #ORD-8942.</div>
                        </div>
                        <span class="text-[10px] text-slate-400">10m ago</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl cursor-pointer transition">
                        <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=f87171&color=fff" class="w-9 h-9 rounded-xl">
                        <div class="flex-grow">
                            <div class="text-xs font-semibold text-slate-900 dark:text-white">Marcus Wright</div>
                            <div class="text-[11px] text-slate-500 line-clamp-1">Could you upgrade our tenant database size?</div>
                        </div>
                        <span class="text-[10px] text-slate-400">2h ago</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications with Badge -->
        <div class="relative">
            <button id="notification-btn" class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 border border-white dark:border-slate-900 rounded-full"></span>
            </button>

            <!-- Notifications Dropdown -->
            <div id="notification-dropdown" class="dropdown-animate hidden-dropdown absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <h6 class="font-bold text-sm text-slate-900 dark:text-white">Notifications</h6>
                    <span class="text-xs text-purple-600 font-semibold cursor-pointer">Clear all</span>
                </div>
                <hr class="border-slate-100 dark:border-slate-800 my-0">
                <div class="space-y-2">
                    <div class="flex gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl cursor-pointer transition">
                        <div class="p-2 bg-green-100 dark:bg-green-500/10 text-green-600 rounded-lg">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-grow">
                            <div class="text-xs font-semibold text-slate-900 dark:text-white">Database Backup Success</div>
                            <div class="text-[10px] text-slate-500">System backup completed.</div>
                        </div>
                    </div>
                    <div class="flex gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl cursor-pointer transition">
                        <div class="p-2 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-lg">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-grow">
                            <div class="text-xs font-semibold text-slate-900 dark:text-white">New user registered</div>
                            <div class="text-[10px] text-slate-500">Sarah Connor signed up.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative ml-2 pl-3 border-l border-slate-200 dark:border-slate-800">
            <button id="topbar-avatar-btn" class="flex items-center gap-2 p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&background=6366f1&color=fff" class="rounded-xl w-8 h-8 object-cover border border-slate-200 dark:border-slate-700">
                <div class="hidden sm:flex flex-col text-left pr-1">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 leading-none">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium mt-1 leading-none">{{ auth()->user()->roles->first()?->name ?? (auth()->user()->is_admin ? 'Super Admin' : 'User') }}</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
            </button>

            <div id="topbar-avatar-dropdown" class="dropdown-animate hidden-dropdown absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-2 space-y-1">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg no-underline transition">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg no-underline transition">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Account Settings</span>
                </a>
                <hr class="border-slate-100 dark:border-slate-800 my-1">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 hover:bg-red-500/10 rounded-lg transition text-left">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
