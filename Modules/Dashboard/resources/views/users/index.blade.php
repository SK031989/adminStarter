@extends('dashboard::layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">User Management</h1>
            <p class="text-xs text-slate-400 font-medium">Manage SaaS application user accounts, access roles, and tenants.</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <!-- Total Users -->
        <div class="col-md-3">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] }}</div>
                    <div class="text-xs text-slate-400 font-medium">Total Users</div>
                </div>
            </div>
        </div>
        <!-- Active -->
        <div class="col-md-3">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 rounded-xl">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['active'] }}</div>
                    <div class="text-xs text-slate-400 font-medium">Active Accounts</div>
                </div>
            </div>
        </div>
        <!-- Pending -->
        <div class="col-md-3">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-amber-100 dark:bg-amber-500/10 text-amber-600 rounded-xl">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-slate-400 font-medium">Pending Verification</div>
                </div>
            </div>
        </div>
        <!-- Suspended -->
        <div class="col-md-3">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-rose-100 dark:bg-rose-500/10 text-rose-600 rounded-xl">
                    <i data-lucide="shield-alert" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['suspended'] }}</div>
                    <div class="text-xs text-slate-400 font-medium">Suspended Accounts</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-2 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Name, email, phone..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(\Modules\Auth\App\Enums\UserStatusEnum::cases() as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ ucfirst($status->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tenant ID --}}
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-1">Tenant ID</label>
                    <input type="number" name="tenant_id" class="form-control"
                           placeholder="Filter by Tenant ID"
                           value="{{ request('tenant_id') }}">
                </div>

                {{-- Buttons --}}
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['search', 'status', 'tenant_id']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i> Clear
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Users Table --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Phone</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Tenant ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff' }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-150 dark:border-slate-700">
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                {{ $user->phone ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg text-xs font-bold">
                                    Tenant #{{ $user->tenant_id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-lg text-xs font-semibold border border-rose-100 dark:border-rose-900/30">
                                        Super Admin
                                    </span>
                                @else
                                    <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        @php
                                            $userRole = $user->roles->first()?->name ?? 'User';
                                        @endphp
                                        <select name="role" onchange="this.form.submit()" class="form-select bg-slate-50 border border-slate-200 dark:bg-slate-850 dark:border-slate-800 text-slate-700 dark:text-slate-300 rounded-lg px-2 py-1 text-xs font-semibold cursor-pointer focus:outline-none focus:ring-1 focus:ring-purple-500">
                                            @foreach($roles as $role)
                                                @if($role->name !== 'Super Admin')
                                                    <option value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </form>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusVal = $user->status instanceof \Modules\Auth\App\Enums\UserStatusEnum ? $user->status->value : $user->status;
                                    $statusClass = 'bg-slate-50 text-slate-500 border-slate-100';
                                    if ($statusVal === 'active') {
                                        $statusClass = 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/30';
                                    } elseif ($statusVal === 'pending') {
                                        $statusClass = 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/30';
                                    } elseif ($statusVal === 'suspended') {
                                        $statusClass = 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-100 dark:border-rose-900/30';
                                    }
                                @endphp
                                <span class="px-2.5 py-1 {{ $statusClass }} rounded-lg text-xs font-bold border">
                                    {{ ucfirst($statusVal) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400 font-medium">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                <i data-lucide="info" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                <span>No users found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
