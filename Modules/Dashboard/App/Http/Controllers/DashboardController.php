<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Models\LoginActivity;
use Modules\Auth\App\Enums\UserStatusEnum;

class DashboardController extends Controller
{
    /**
     * Display the admin control panel.
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect()->route('admin.dashboard');
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect()->route('dashboard');
            }
        }
        // Gather real database metrics
        $totalUsers = User::count();
        $activeAdmins = User::where('is_admin', true)->count();
        $totalLogs = LoginActivity::count();
        $successfulLogs = LoginActivity::where('status', 'success')->count();

        // Calculate a simulated growth and value for SaaS presentation
        $metrics = [
            'total_users'     => $totalUsers,
            'active_admins'   => $activeAdmins,
            'total_logs'      => $totalLogs,
            'successful_logs' => $successfulLogs,
            
            // Modern SaaS Metrics (KPI Cards)
            'sales' => [
                'value' => '$45,289.40',
                'change' => '+12.5%',
                'trend' => 'up',
            ],
            'users' => [
                'value' => number_format($totalUsers > 0 ? $totalUsers : 1248),
                'change' => '+4.3%',
                'trend' => 'up',
            ],
            'orders' => [
                'value' => '1,482',
                'change' => '-2.1%',
                'trend' => 'down',
            ],
            'revenue' => [
                'value' => '$98,245.00',
                'change' => '+28.4%',
                'trend' => 'up',
            ],
        ];

        // Retrieve last 10 login activities
        $recentLogs = LoginActivity::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // High-fidelity Mock Orders
        $recentOrders = [
            [
                'id' => '#ORD-8942',
                'customer' => 'Sarah Connor',
                'email' => 'sarah@cyberdyne.io',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Connor&background=c084fc&color=fff',
                'product' => 'Growth Pro Monthly',
                'amount' => '$29.00',
                'status' => 'Completed',
                'date' => 'July 01, 2026',
            ],
            [
                'id' => '#ORD-8941',
                'customer' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=60a5fa&color=fff',
                'product' => 'Enterprise Custom Pack',
                'amount' => '$1,490.00',
                'status' => 'Completed',
                'date' => 'June 30, 2026',
            ],
            [
                'id' => '#ORD-8940',
                'customer' => 'Marcus Wright',
                'email' => 'marcus@projectangel.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Marcus+Wright&background=f87171&color=fff',
                'product' => 'Growth Pro Annual',
                'amount' => '$290.00',
                'status' => 'Pending',
                'date' => 'June 30, 2026',
            ],
            [
                'id' => '#ORD-8939',
                'customer' => 'Ellen Ripley',
                'email' => 'ripley@weyland.org',
                'avatar' => 'https://ui-avatars.com/api/?name=Ellen+Ripley&background=34d399&color=fff',
                'product' => 'Starter Monthly',
                'amount' => '$9.00',
                'status' => 'Completed',
                'date' => 'June 29, 2026',
            ],
            [
                'id' => '#ORD-8938',
                'customer' => 'Peter Parker',
                'email' => 'peter.parker@dailybugle.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Peter+Parker&background=fbbf24&color=fff',
                'product' => 'Growth Pro Monthly',
                'amount' => '$29.00',
                'status' => 'Cancelled',
                'date' => 'June 28, 2026',
            ],
        ];

        // Top Products List
        $topProducts = [
            [
                'name' => 'Growth Pro Monthly',
                'category' => 'SaaS Subscription',
                'sales' => 842,
                'revenue' => '$24,418.00',
                'percentage' => 78,
                'color' => 'bg-purple-600',
            ],
            [
                'name' => 'Enterprise Scale Pack',
                'category' => 'Custom Plan',
                'sales' => 312,
                'revenue' => '$46,488.00',
                'percentage' => 54,
                'color' => 'bg-blue-600',
            ],
            [
                'name' => 'Starter Plan Annual',
                'category' => 'SaaS Subscription',
                'sales' => 240,
                'revenue' => '$2,160.00',
                'percentage' => 35,
                'color' => 'bg-indigo-600',
            ],
            [
                'name' => 'Developer API Access Addon',
                'category' => 'API Token Usage',
                'sales' => 195,
                'revenue' => '$9,750.00',
                'percentage' => 28,
                'color' => 'bg-emerald-600',
            ],
        ];

        // Sales Line Chart Data (Monthly representation)
        $salesChart = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'sales' => [28000, 32000, 31000, 38000, 42000, 40000, 45289, 48000, 52000, 50000, 58000, 64000],
            'revenue' => [18000, 22000, 25000, 24000, 30000, 29000, 32000, 35000, 38000, 36000, 41000, 48000]
        ];

        // Donut Chart Order Status
        $orderStatusChart = [
            'labels' => ['Completed', 'Pending', 'Processing', 'Cancelled'],
            'series' => [65, 18, 12, 5]
        ];

        return view('dashboard::index', compact(
            'metrics', 
            'recentLogs', 
            'recentOrders', 
            'topProducts', 
            'salesChart', 
            'orderStatusChart'
        ));
    }

    /**
     * Privacy Policy page.
     */
    public function privacyPolicy(): View|RedirectResponse
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect()->route('admin.privacy-policy');
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect()->route('privacy-policy');
            }
        }
        return view('dashboard::pages.privacy-policy');
    }

    /**
     * Terms of Service page.
     */
    public function termsOfService(): View|RedirectResponse
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect()->route('admin.terms-of-service');
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect()->route('terms-of-service');
            }
        }
        return view('dashboard::pages.terms-of-service');
    }

    /**
     * Support page.
     */
    public function support(): View|RedirectResponse
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect()->route('admin.support');
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect()->route('support');
            }
        }
        return view('dashboard::pages.support');
    }

    /**
     * Show general settings.
     */
    public function settings(): View
    {
        $settingsPath = config_path('settings.json');
        $activeTheme = 'obsidian';
        $projectName = 'SaaSStater';
        $projectLogo = 'shield';
        $projectDescription = '';

        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $activeTheme = $settings['active_theme'] ?? 'obsidian';
            $projectName = $settings['project_name'] ?? 'SaaSStater';
            $projectLogo = $settings['project_logo'] ?? 'shield';
            $projectDescription = $settings['project_description'] ?? '';
        }

        return view('dashboard::settings', compact('activeTheme', 'projectName', 'projectLogo', 'projectDescription'));
    }

    /**
     * Update general settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'theme' => 'required|string|in:obsidian,cyber,astral,minimal',
            'project_name' => 'required|string|max:50',
            'project_logo' => 'required|string|max:50',
            'project_description' => 'nullable|string|max:500',
        ]);

        $settingsPath = config_path('settings.json');
        $settings = [];
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
        }

        $settings['active_theme'] = $request->input('theme');
        $settings['project_name'] = $request->input('project_name');
        $settings['project_logo'] = $request->input('project_logo');
        $settings['project_description'] = $request->input('project_description');

        file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));

        // Update active config values immediately
        config([
            'app.name' => $settings['project_name'],
            'settings.project_name' => $settings['project_name'],
            'settings.project_logo' => $settings['project_logo'],
            'settings.active_theme' => $settings['active_theme'],
            'settings.project_description' => $settings['project_description'],
        ]);

        return back()->with('success', 'System configuration updated successfully.');
    }

    /**
     * Display a list of all users in the system.
     */
    public function users(Request $request): View
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Tenant filter
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->input('tenant_id'));
        }

        // Paginate users
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Get count metrics for stats cards
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', UserStatusEnum::Active->value ?? 'active')->count(),
            'pending' => User::where('status', UserStatusEnum::Pending->value ?? 'pending')->count(),
            'suspended' => User::where('status', UserStatusEnum::Suspended->value ?? 'suspended')->count(),
        ];

        $roles = \Spatie\Permission\Models\Role::all();

        return view('dashboard::users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Display a list of all roles.
     */
    public function rolesList(): View
    {
        $roles = \Spatie\Permission\Models\Role::withCount('users')->get();
        return view('dashboard::roles.index', compact('roles'));
    }

    /**
     * Show create role form.
     */
    public function roleCreate(): View
    {
        // Get all module permissions grouped by module
        $modules = [];
        if (class_exists('\Modules\ModuleBuilder\App\Models\DynamicModule')) {
            $modules = \Modules\ModuleBuilder\App\Models\DynamicModule::active()->with('permissions')->get();
        }
        
        return view('dashboard::roles.create', compact('modules'));
    }

    /**
     * Store a new role.
     */
    public function roleStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = \Spatie\Permission\Models\Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            // First ensure permissions exist in Spatie permission table
            foreach ($request->input('permissions') as $permKey) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $permKey,
                    'guard_name' => 'web',
                ]);
            }
            $role->syncPermissions($request->input('permissions'));
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show edit role form.
     */
    public function roleEdit($roleId): View
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($roleId);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        $modules = [];
        if (class_exists('\Modules\ModuleBuilder\App\Models\DynamicModule')) {
            $modules = \Modules\ModuleBuilder\App\Models\DynamicModule::active()->with('permissions')->get();
        }

        return view('dashboard::roles.edit', compact('role', 'rolePermissions', 'modules'));
    }

    /**
     * Update an existing role.
     */
    public function roleUpdate(Request $request, $roleId): RedirectResponse
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($roleId);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->input('name'),
        ]);

        if ($request->has('permissions')) {
            // First ensure permissions exist in Spatie permission table
            foreach ($request->input('permissions') as $permKey) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $permKey,
                    'guard_name' => 'web',
                ]);
            }
            $role->syncPermissions($request->input('permissions'));
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role.
     */
    public function roleDestroy($roleId): RedirectResponse
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($roleId);
        
        // Prevent deleting core roles
        if (in_array($role->name, ['Super Admin', 'Tenant Admin', 'User'])) {
            return back()->with('error', 'Core roles cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Update user role.
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        // Sync roles (Spatie handles multiple roles, but we assign one primary role)
        $user->syncRoles([$request->input('role')]);

        return back()->with('success', "Updated role for {$user->name} successfully.");
    }
}
