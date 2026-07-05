@extends('dashboard::layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 fw-bold mb-0">Edit Role & Permissions</h1>
                <p class="text-muted small mb-0">Modify access privileges and capability settings for this role.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Roles
            </a>
        </div>

        {{-- Form --}}
        <div class="card border-0 shadow-sm p-4">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label font-semibold text-slate-700 dark:text-slate-300">Role Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="form-control @error('name') is-invalid @enderror" required {{ in_array($role->name, ['Super Admin', 'Tenant Admin', 'User']) ? 'readonly' : '' }}>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Permissions Matrix --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label font-semibold text-slate-700 dark:text-slate-300 mb-0">Role Permissions</label>
                        @if($role->name === 'Super Admin')
                            <span class="badge bg-danger bg-opacity-10 text-danger small">Super Admin gets all privileges automatically</span>
                        @endif
                    </div>

                    @if(count($modules) > 0)
                        <div class="border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="table table-hover align-middle mb-0 text-sm">
                                    <thead>
                                        <tr class="bg-slate-50 dark:bg-slate-850">
                                            <th class="px-4 py-3 fw-bold text-slate-500">Module / Resource</th>
                                            <th class="px-4 py-3 text-center fw-bold text-slate-500">View</th>
                                            <th class="px-4 py-3 text-center fw-bold text-slate-500">Create</th>
                                            <th class="px-4 py-3 text-center fw-bold text-slate-500">Update</th>
                                            <th class="px-4 py-3 text-center fw-bold text-slate-500">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                        @foreach($modules as $module)
                                            <tr>
                                                <td class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi {{ $module->icon ?? 'bi-grid-3x3' }} text-primary"></i>
                                                        <span>{{ $module->name }}</span>
                                                    </div>
                                                </td>
                                                @php
                                                    $slug = $module->slug;
                                                    $actions = ['view', 'create', 'update', 'delete'];
                                                @endphp
                                                @foreach($actions as $action)
                                                    @php
                                                        $permKey = "{$slug}.{$action}";
                                                        $checked = in_array($permKey, $rolePermissions);
                                                    @endphp
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permKey }}" class="form-check-input" id="check-{{ $permKey }}" {{ $checked ? 'checked' : '' }} {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-slate-50 dark:bg-slate-850 rounded-2xl text-center text-slate-400">
                            <i class="bi bi-info-circle fs-4 mb-2 d-block"></i>
                            <span>No dynamic modules have been generated yet. Create a module in the Module Builder first.</span>
                        </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="pt-3 border-top border-slate-100 dark:border-slate-800 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    @if($role->name !== 'Super Admin')
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    @endif
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
