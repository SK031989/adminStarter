@extends('dashboard::layouts.admin')

@section('title', 'Roles & Permissions')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-0">Roles & Permissions</h1>
            <p class="text-muted small mb-0">Manage authorization roles, user accesses, and dynamic module permission levels.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Role
        </a>
    </div>

    {{-- Session alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Roles Cards/Grid --}}
    <div class="row g-3">
        @foreach($roles as $role)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    {{ $role->name }}
                                </span>
                                <span class="small text-muted font-medium">
                                    {{ $role->users_count }} {{ Str::plural('User', $role->users_count) }}
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-slate-800 dark:text-slate-100 mb-2">{{ $role->name }}</h5>
                            <p class="card-text text-muted small mb-4">
                                @if($role->name === 'Super Admin')
                                    Has absolute system administrator privileges and bypasses all validation gates.
                                @elseif($role->name === 'Tenant Admin')
                                    Has general management permissions for their tenant team data.
                                @elseif($role->name === 'User')
                                    Default role assigned to standard authenticated members.
                                @else
                                    Custom user role configured for targeted team workflow control.
                                @endif
                            </p>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top border-slate-100 dark:border-slate-800">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                <i class="bi bi-shield-lock me-1"></i> Permissions
                            </a>
                            
                            @if(!in_array($role->name, ['Super Admin', 'Tenant Admin', 'User']))
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Are you sure you want to delete this custom role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
