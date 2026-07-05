<?php

namespace Modules\ModuleBuilder\App\Services;

use Modules\ModuleBuilder\App\Models\DynamicModule;

class ViewGeneratorService
{
    /**
     * Generate all Blade view files for the given DynamicModule.
     *
     * @return array<string, string>  map of view => path
     */
    public function generate(DynamicModule $module): array
    {
        $className  = $module->module_class_name;
        $routeName  = $module->route_name;
        $viewsPath  = base_path("Modules/{$className}/resources/views");
        $partialsPath = $viewsPath . '/partials';

        foreach ([$viewsPath, $partialsPath] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        $generated = [];

        // Partials first (form, table, filters, actions)
        $generated['form']    = $this->writeFile($partialsPath . '/form.blade.php',    $this->buildFormPartial($module));
        $generated['table']   = $this->writeFile($partialsPath . '/table.blade.php',   $this->buildTablePartial($module));
        $generated['filters'] = $this->writeFile($partialsPath . '/filters.blade.php', $this->buildFiltersPartial($module));
        $generated['actions'] = $this->writeFile($partialsPath . '/actions.blade.php', $this->buildActionsPartial($module));

        // Main views
        $generated['index']  = $this->writeFile($viewsPath . '/index.blade.php',  $this->buildIndex($module));
        $generated['create'] = $this->writeFile($viewsPath . '/create.blade.php', $this->buildCreate($module));
        $generated['edit']   = $this->writeFile($viewsPath . '/edit.blade.php',   $this->buildEdit($module));
        $generated['show']   = $this->writeFile($viewsPath . '/show.blade.php',   $this->buildShow($module));

        return $generated;
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    private function buildIndex(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $routeName = $module->route_name;
        $varName   = lcfirst($className);

        return <<<BLADE
@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', '{$className} — List')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">{{ __('{$className}') }}</h1>
            <p class="text-muted mb-0 small">Manage all {$className} records</p>
        </div>
        @can('{$routeName}.create')
        <a href="{{ route('{$routeName}.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add {$className}
        </a>
        @endcan
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filters --}}
    @include('{$routeName}::partials.filters')

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @include('{$routeName}::partials.table', ['{$varName}s' => \${$varName}s])
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Showing {{ \${$varName}s->firstItem() }}–{{ \${$varName}s->lastItem() }} of {{ \${$varName}s->total() }} records
        </small>
        {{ \${$varName}s->withQueryString()->links() }}
    </div>

</div>
@endsection
BLADE;
    }

    // -------------------------------------------------------------------------
    // Create
    // -------------------------------------------------------------------------

    private function buildCreate(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $routeName = $module->route_name;

        return <<<BLADE
@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', 'Create {$className}')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Create {$className}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$className}</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('{$routeName}.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                @csrf
                @include('{$routeName}::partials.form')
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Save {$className}
                    </button>
                    <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
BLADE;
    }

    // -------------------------------------------------------------------------
    // Edit
    // -------------------------------------------------------------------------

    private function buildEdit(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $routeName = $module->route_name;
        $varName   = lcfirst($className);

        return <<<BLADE
@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', 'Edit {$className}')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Edit {$className}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$className}</a></li>
                    <li class="breadcrumb-item active">Edit #{{ \${$varName}->id }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('{$routeName}.update', \${$varName}) }}" method="POST" enctype="multipart/form-data" id="edit-form">
                @csrf
                @method('PUT')
                @include('{$routeName}::partials.form', ['model' => \${$varName}])
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update {$className}
                    </button>
                    <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    @can('{$routeName}.delete')
                    <form action="{{ route('{$routeName}.destroy', \${$varName}) }}" method="POST" class="ms-auto"
                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
BLADE;
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    private function buildShow(DynamicModule $module): string
    {
        $className  = $module->module_class_name;
        $routeName  = $module->route_name;
        $varName    = lcfirst($className);
        $fieldRows  = $this->buildShowFieldRows($module);

        return <<<BLADE
@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', '{$className} Detail')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">{$className} Detail</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$className}</a></li>
                    <li class="breadcrumb-item active">#{{ \${$varName}->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @can('{$routeName}.update')
            <a href="{{ route('{$routeName}.edit', \${$varName}) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            @endcan
            <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Detail Card --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom fw-semibold">
                    {$className} Information
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted">ID</dt>
                        <dd class="col-sm-9">{{ \${$varName}->id }}</dd>

{$fieldRows}

                        <dt class="col-sm-3 text-muted">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-{{ \${$varName}->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst(\${$varName}->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-3 text-muted">Created At</dt>
                        <dd class="col-sm-9">{{ \${$varName}->created_at?->format('d M Y, H:i') }}</dd>

                        <dt class="col-sm-3 text-muted">Updated At</dt>
                        <dd class="col-sm-9">{{ \${$varName}->updated_at?->format('d M Y, H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Activity Sidebar --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom fw-semibold">Activity</div>
                <div class="card-body">
                    <p class="text-muted small mb-0">Activity log will appear here.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
BLADE;
    }

    // -------------------------------------------------------------------------
    // Partials
    // -------------------------------------------------------------------------

    private function buildFormPartial(DynamicModule $module): string
    {
        $fields = $this->buildFormFields($module);

        return <<<BLADE
{{--
    Shared form partial used by both create.blade.php and edit.blade.php.
    Pass \$model for edit mode (pre-fills values).
    Supports old(), existing model values, validation errors, file upload,
    select, checkbox, radio, and boolean fields.
--}}

@if(\$errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">
        @foreach(\$errors->all() as \$error)
            <li>{{ \$error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">

{$fields}

    {{-- Status --}}
    <div class="col-md-6">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            <option value="active"   {{ old('status', \$model->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', \$model->status ?? '')       === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>

</div>
BLADE;
    }

    private function buildFormFields(DynamicModule $module): string
    {
        $lines = [];

        foreach ($module->fields as $field) {
            $lines[] = $this->buildSingleFormField($field);
        }

        return implode("\n\n", $lines);
    }

    private function buildSingleFormField($field): string
    {
        $name       = $field->field_name;
        $label      = $field->label;
        $required   = $field->is_required ? 'required' : '';
        $requiredMark = $field->is_required ? '<span class="text-danger">*</span>' : '';
        $type       = $field->type;
        $placeholder = $field->placeholder ?? $label;

        return match (true) {
            $type->value === 'textarea' => <<<BLADE
    <div class="col-md-12">
        <label for="{$name}" class="form-label fw-semibold">{$label} {$requiredMark}</label>
        <textarea name="{$name}" id="{$name}" rows="4"
            class="form-control @error('{$name}') is-invalid @enderror"
            placeholder="{$placeholder}" {$required}>{{ old('{$name}', \$model->{$name} ?? '') }}</textarea>
        @error('{$name}') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>
BLADE,

            $type->value === 'boolean' => <<<BLADE
    <div class="col-md-6">
        <label class="form-label fw-semibold d-block">{$label}</label>
        <div class="form-check form-switch">
            <input type="hidden" name="{$name}" value="0">
            <input type="checkbox" name="{$name}" id="{$name}" value="1"
                class="form-check-input @error('{$name}') is-invalid @enderror"
                {{ old('{$name}', \$model->{$name} ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="{$name}">Enable</label>
        </div>
        @error('{$name}') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>
BLADE,

            $type->value === 'select' => <<<BLADE
    <div class="col-md-6">
        <label for="{$name}" class="form-label fw-semibold">{$label} {$requiredMark}</label>
        <select name="{$name}" id="{$name}" class="form-select @error('{$name}') is-invalid @enderror" {$required}>
            <option value="">— Select {$label} —</option>
            @foreach(\$field_{$name}_options ?? [] as \$value => \$optLabel)
                <option value="{{ \$value }}" {{ old('{$name}', \$model->{$name} ?? '') == \$value ? 'selected' : '' }}>
                    {{ \$optLabel }}
                </option>
            @endforeach
        </select>
        @error('{$name}') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>
BLADE,

            $type->value === 'radio' => <<<BLADE
    <div class="col-md-6">
        <label class="form-label fw-semibold">{$label} {$requiredMark}</label>
        @foreach(\$field_{$name}_options ?? [] as \$value => \$optLabel)
        <div class="form-check">
            <input type="radio" name="{$name}" id="{$name}_{{ \$loop->index }}" value="{{ \$value }}"
                class="form-check-input @error('{$name}') is-invalid @enderror"
                {{ old('{$name}', \$model->{$name} ?? '') == \$value ? 'checked' : '' }} {$required}>
            <label class="form-check-label" for="{$name}_{{ \$loop->index }}">{{ \$optLabel }}</label>
        </div>
        @endforeach
        @error('{$name}') <div class="invalid-feedback d-block">{{ \$message }}</div> @enderror
    </div>
BLADE,

            $type->value === 'checkbox' => <<<BLADE
    <div class="col-md-6">
        <label class="form-label fw-semibold">{$label} {$requiredMark}</label>
        <input type="hidden" name="{$name}[]" value="">
        @foreach(\$field_{$name}_options ?? [] as \$value => \$optLabel)
        <div class="form-check">
            <input type="checkbox" name="{$name}[]" id="{$name}_{{ \$loop->index }}" value="{{ \$value }}"
                class="form-check-input @error('{$name}') is-invalid @enderror"
                {{ in_array(\$value, old('{$name}', \$model->{$name} ?? [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="{$name}_{{ \$loop->index }}">{{ \$optLabel }}</label>
        </div>
        @endforeach
        @error('{$name}') <div class="invalid-feedback d-block">{{ \$message }}</div> @enderror
    </div>
BLADE,

            in_array($type->value, ['file', 'image']) => <<<BLADE
    <div class="col-md-6">
        <label for="{$name}" class="form-label fw-semibold">{$label} {$requiredMark}</label>
        @if(!empty(\$model->{$name}))
            <div class="mb-2">
                <img src="{{ asset('storage/' . \$model->{$name}) }}" alt="{$label}" class="img-thumbnail" style="max-height:80px;">
            </div>
        @endif
        <input type="file" name="{$name}" id="{$name}"
            class="form-control @error('{$name}') is-invalid @enderror"
            accept="{{ '{$type->value}' === 'image' ? 'image/*' : '*' }}" {$required}>
        @error('{$name}') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>
BLADE,

            default => <<<BLADE
    <div class="col-md-6">
        <label for="{$name}" class="form-label fw-semibold">{$label} {$requiredMark}</label>
        <input type="{$type->htmlInputType()}" name="{$name}" id="{$name}"
            class="form-control @error('{$name}') is-invalid @enderror"
            value="{{ old('{$name}', \$model->{$name} ?? '') }}"
            placeholder="{$placeholder}" {$required}>
        @error('{$name}') <div class="invalid-feedback">{{ \$message }}</div> @enderror
    </div>
BLADE,
        };
    }

    private function buildTablePartial(DynamicModule $module): string
    {
        $className  = $module->module_class_name;
        $routeName  = $module->route_name;
        $varName    = lcfirst($className);
        $headers    = $this->buildTableHeaders($module);
        $cells      = $this->buildTableCells($module, $varName);

        return <<<BLADE
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>
{$headers}
                <th>Status</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse(\${$varName}s as \$item)
            <tr>
                <td class="text-muted small">{{ \$item->id }}</td>
{$cells}
                <td>
                    <span class="badge bg-{{ \$item->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst(\$item->status) }}
                    </span>
                </td>
                <td class="text-muted small">{{ \$item->created_at?->format('d M Y') }}</td>
                <td class="text-end">
                    @include('{$routeName}::partials.actions', ['item' => \$item])
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="99" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    No records found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
BLADE;
    }

    private function buildTableHeaders(DynamicModule $module): string
    {
        return $module->fields
            ->take(4)
            ->map(fn ($f) => "                <th>{$f->label}</th>")
            ->implode("\n");
    }

    private function buildTableCells(DynamicModule $module, string $varName): string
    {
        return $module->fields
            ->take(4)
            ->map(fn ($f) => "                <td>{{ \$item->{$f->field_name} }}</td>")
            ->implode("\n");
    }

    private function buildFiltersPartial(DynamicModule $module): string
    {
        $routeName   = $module->route_name;
        $filterFields = $this->buildFilterInputs($module);

        return <<<BLADE
<form method="GET" action="{{ route('{$routeName}.index') }}" class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-2 align-items-end">

            {{-- Search --}}
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search..."
                           value="{{ request('search') }}">
                </div>
            </div>

{$filterFields}

            {{-- Status --}}
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('{$routeName}.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>
BLADE;
    }

    private function buildFilterInputs(DynamicModule $module): string
    {
        return $module->fields
            ->where('is_filterable', true)
            ->take(2)
            ->map(function ($field) {
                return <<<BLADE

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">{$field->label}</label>
                <input type="text" name="{$field->field_name}" class="form-control"
                       placeholder="{$field->label}" value="{{ request('{$field->field_name}') }}">
            </div>
BLADE;
            })
            ->implode("\n");
    }

    private function buildActionsPartial(DynamicModule $module): string
    {
        $routeName = $module->route_name;
        $varName   = lcfirst($module->module_class_name);
        $className = $module->module_class_name;

        return <<<BLADE
<div class="d-flex justify-content-end gap-1">
    @can('{$routeName}.view')
    <a href="{{ route('{$routeName}.show', \$item) }}"
       class="btn btn-sm btn-outline-info" title="View">
        <i class="bi bi-eye"></i>
    </a>
    @endcan

    @can('{$routeName}.update')
    <a href="{{ route('{$routeName}.edit', \$item) }}"
       class="btn btn-sm btn-outline-primary" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan

    @can('{$routeName}.delete')
    <form action="{{ route('{$routeName}.destroy', \$item) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Delete this record?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endcan
</div>
BLADE;
    }

    private function buildShowFieldRows(DynamicModule $module): string
    {
        return $module->fields->map(function ($field) {
            return <<<BLADE

                        <dt class="col-sm-3 text-muted">{$field->label}</dt>
                        <dd class="col-sm-9">{{ \${varName}->{$field->field_name} ?? '—' }}</dd>
BLADE;
        })->implode("\n");
    }

    // -------------------------------------------------------------------------
    // Utility
    // -------------------------------------------------------------------------

    private function writeFile(string $path, string $content): string
    {
        file_put_contents($path, $content);
        return $path;
    }
}
