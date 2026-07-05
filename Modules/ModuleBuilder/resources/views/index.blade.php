@extends('module-builder::layouts.app')

@section('title', 'Module Builder — All Modules')

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    @php
        $statusColors = ['active' => 'success', 'inactive' => 'secondary'];
        $total = array_sum($stats);
    @endphp
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-primary bg-opacity-10">
                    <i class="bi bi-grid-3x3 fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $total }}</div>
                    <div class="text-muted small">Total Modules</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-success bg-opacity-10">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['active'] ?? 0 }}</div>
                    <div class="text-muted small">Active</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-warning bg-opacity-10">
                    <i class="bi bi-lightning fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $modules->where('is_generated', true)->count() }}</div>
                    <div class="text-muted small">Generated</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-secondary bg-opacity-10">
                    <i class="bi bi-pause-circle fs-4 text-secondary"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['inactive'] ?? 0 }}</div>
                    <div class="text-muted small">Inactive</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 fw-bold mb-0">Dynamic Modules</h1>
        <p class="text-muted small mb-0">Build, manage and generate custom modules</p>
    </div>
    @can('create', \Modules\ModuleBuilder\App\Models\DynamicModule::class)
    <a href="{{ route('module-builder.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Module
    </a>
    @endcan
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-x-circle me-1"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Filters --}}
@include('module-builder::partials.filters')

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @include('module-builder::partials.table', ['modules' => $modules])
    </div>
</div>

{{-- Pagination --}}
@if($modules->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">
        Showing {{ $modules->firstItem() }}–{{ $modules->lastItem() }} of {{ $modules->total() }} modules
    </small>
    {{ $modules->withQueryString()->links() }}
</div>
@endif

@endsection
