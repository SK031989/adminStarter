@extends('module-builder::layouts.app')

@section('title', $module->name . ' — Module Detail')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="bi {{ $module->icon ?? 'bi-grid' }} text-primary"></i>
            {{ $module->name }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('module-builder.index') }}">Modules</a></li>
                <li class="breadcrumb-item active">{{ $module->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @can('update', $module)
        <a href="{{ route('module-builder.edit', $module) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        @endcan
        @if(!$module->is_generated)
        <form action="{{ route('module-builder.generate', $module) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm"
                    onclick="return confirm('Generate all module files now?')">
                <i class="bi bi-lightning me-1"></i> Generate Module
            </button>
        </form>
        @else
        <span class="btn btn-sm btn-outline-success disabled">
            <i class="bi bi-check-circle me-1"></i> Generated
        </span>
        @endif
        <a href="{{ route('module-builder.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- Module Info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-semibold py-3">Module Info</div>
            <div class="card-body">
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Name</dt>
                    <dd class="col-7">{{ $module->name }}</dd>

                    <dt class="col-5 text-muted">Slug</dt>
                    <dd class="col-7"><code>{{ $module->slug }}</code></dd>

                    <dt class="col-5 text-muted">Table</dt>
                    <dd class="col-7"><code>{{ $module->table_name }}</code></dd>

                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7">
                        <span class="badge bg-{{ $module->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($module->status) }}
                        </span>
                    </dd>

                    <dt class="col-5 text-muted">Generated</dt>
                    <dd class="col-7">
                        @if($module->is_generated)
                            <span class="badge bg-success"><i class="bi bi-check"></i> Yes</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass"></i> Pending</span>
                        @endif
                    </dd>

                    <dt class="col-5 text-muted">Fields</dt>
                    <dd class="col-7"><strong>{{ $module->fields->count() }}</strong></dd>

                    <dt class="col-5 text-muted">Created</dt>
                    <dd class="col-7">{{ $module->created_at?->format('d M Y') }}</dd>
                </dl>

                @if($module->description)
                <hr>
                <p class="text-muted small mb-0">{{ $module->description }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Fields Table --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Fields <span class="badge bg-primary ms-1">{{ $module->fields->count() }}</span></span>
                <a href="{{ route('module-builder.edit', $module) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> Manage Fields
                </a>
            </div>
            <div class="card-body p-0">
                @if($module->fields->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Field Name</th>
                                <th>Label</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Searchable</th>
                                <th>Filterable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($module->fields as $i => $field)
                            <tr>
                                <td class="text-muted small">{{ $i + 1 }}</td>
                                <td><code>{{ $field->field_name }}</code></td>
                                <td>{{ $field->label }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $field->type->label() }}</span></td>
                                <td>{!! $field->is_required   ? '<i class="bi bi-check-circle text-success"></i>' : '<i class="bi bi-dash text-muted"></i>' !!}</td>
                                <td>{!! $field->is_searchable ? '<i class="bi bi-check-circle text-success"></i>' : '<i class="bi bi-dash text-muted"></i>' !!}</td>
                                <td>{!! $field->is_filterable ? '<i class="bi bi-check-circle text-success"></i>' : '<i class="bi bi-dash text-muted"></i>' !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-collection fs-2 d-block mb-2"></i>
                    No fields yet.
                    <a href="{{ route('module-builder.edit', $module) }}" class="d-block mt-1">Add fields now</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Permissions --}}
    @if($module->permissions->isNotEmpty())
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 fw-semibold">
                Permissions <span class="badge bg-primary ms-1">{{ $module->permissions->count() }}</span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($module->permissions as $perm)
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <code>{{ $perm->permission_key }}</code>
                        <span class="text-muted small">{{ $perm->label }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Generated Path --}}
    @if($module->is_generated && $module->generation_path)
    <div class="col-12">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-1"><i class="bi bi-folder2-open me-1 text-success"></i> Generation Path</h6>
                <code class="small">{{ $module->generation_path }}</code>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
