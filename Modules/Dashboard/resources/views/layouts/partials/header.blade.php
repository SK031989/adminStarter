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

        <!-- ===== COLOR PALETTE PICKER ===== -->
        <div class="relative">
            <button id="color-palette-btn" type="button" title="Accent Color"
                class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition flex items-center justify-center">
                <i data-lucide="palette" class="w-5 h-5"></i>
            </button>

            <!-- ── Color Palette Panel ── -->
            <div id="color-palette-dropdown"
                class="dropdown-animate hidden-dropdown absolute right-0 mt-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl z-50 overflow-hidden"
                style="width: 300px;">

                <!-- Scrollbar styles -->
                <style>
                    #palette-swatches-scroll::-webkit-scrollbar { width: 3px; }
                    #palette-swatches-scroll::-webkit-scrollbar-track { background: transparent; }
                    #palette-swatches-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
                    #palette-swatches-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
                </style>

                <!-- ▸ Gradient Header -->
                <div id="palette-header-strip"
                    style="background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);
                           padding: 18px 20px 20px; position: relative; overflow: hidden;">
                    <!-- decorative blobs -->
                    <div style="position:absolute; top:-20px; right:-20px; width:90px; height:90px; border-radius:9999px; background:rgba(255,255,255,0.12);"></div>
                    <div style="position:absolute; bottom:-30px; left:-10px; width:100px; height:100px; border-radius:9999px; background:rgba(255,255,255,0.06);"></div>
                    <div style="position:absolute; top:50%; right:60px; width:40px; height:40px; border-radius:9999px; background:rgba(255,255,255,0.08); transform:translateY(-50%);"></div>
                    <!-- content row -->
                    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:space-between; gap:12px;">
                        <div style="flex:1; min-width:0;">
                            <p style="font-size:9px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.14em; margin:0 0 5px;">Accent Color</p>
                            <p id="palette-current-name" style="font-size:20px; font-weight:800; color:#fff; margin:0 0 4px; line-height:1; letter-spacing:-0.5px;">Purple</p>
                            <p id="palette-current-hex" style="font-size:11px; font-weight:600; color:rgba(255,255,255,0.55); margin:0; letter-spacing:0.04em; font-family:monospace;">#a855f7</p>
                        </div>
                        <div style="width:46px; height:46px; border-radius:9999px; background:rgba(255,255,255,0.18); border:2px solid rgba(255,255,255,0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; backdrop-filter:blur(4px);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 8 6.5 8 8 8.67 8 9.5 7.33 11 6.5 11zm3-4C8.67 7 8 6.33 8 5.5S8.67 4 9.5 4s1.5.67 1.5 1.5S10.33 7 9.5 7zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 4 14.5 4s1.5.67 1.5 1.5S15.33 7 14.5 7zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 8 17.5 8s1.5.67 1.5 1.5S18.33 11 17.5 11z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- ▸ Swatch Section -->
                <div style="padding: 12px 16px 8px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                        <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em;">Choose Theme</span>
                        <span id="palette-color-count" style="font-size:9px; font-weight:600; color:#94a3b8; background:#f1f5f9; padding:2px 8px; border-radius:999px;">24 colors</span>
                    </div>
                    <div style="position:relative;">
                        <div id="palette-swatches-scroll"
                            style="max-height: 230px; overflow-y: auto; padding-right: 2px;
                                   scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
                            <div id="palette-groups"></div>
                        </div>
                        <div id="palette-scroll-fade"
                            style="position:absolute; bottom:0; left:0; right:4px; height:36px;
                                   background: linear-gradient(to top, #ffffff 20%, rgba(255,255,255,0) 100%);
                                   pointer-events:none; transition: opacity 0.2s;">
                        </div>
                    </div>
                </div>

                <!-- ▸ Footer -->
                <div style="padding: 10px 16px 14px; display:flex; align-items:center; justify-content:space-between; gap:10px; border-top:1px solid #f1f5f9;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#94a3b8" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span style="font-size:10px; color:#94a3b8;">Saved automatically</span>
                    </div>
                    <button id="palette-reset-btn" type="button"
                        style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:10px; border:1px solid #e2e8f0; font-size:11px; font-weight:600; color:#64748b; background:transparent; cursor:pointer; transition:all 0.15s; white-space:nowrap;"
                        onmouseover="this.style.borderColor='#fca5a5';this.style.color='#ef4444';this.style.background='#fff1f2';"
                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color:#64748b;this.style.background='transparent';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v5h5"/>
                        </svg>
                        Reset
                    </button>
                </div>

            </div>
        </div>

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
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&background=6366f1&color=fff" class="accent-avatar rounded-xl w-8 h-8 object-cover border border-slate-200 dark:border-slate-700">
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
