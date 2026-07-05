@extends('module-builder::layouts.app')

@section('title', 'Edit Module — ' . $module->name)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Edit Module: {{ $module->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('module-builder.index') }}">Modules</a></li>
                <li class="breadcrumb-item"><a href="{{ route('module-builder.show', $module) }}">{{ $module->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('module-builder.show', $module) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- Module Form --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 fw-semibold">Module Settings</div>
            <div class="card-body">
                <form action="{{ route('module-builder.update', $module) }}" method="POST" id="edit-module-form">
                    @csrf
                    @method('PUT')
                    @include('module-builder::partials.form', ['model' => $module])
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update Module
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Fields Management --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Fields <span class="badge bg-primary ms-1">{{ $module->fields->count() }}</span></span>
            </div>
            <div class="card-body">
                @include('module-builder::partials.field-form', ['module' => $module])
            </div>

            {{-- Existing Fields List --}}
            @if($module->fields->isNotEmpty())
            <div class="card-footer bg-transparent">
                <small class="text-muted d-block mb-2">Drag to reorder</small>
                <ul class="list-group list-group-flush" id="fields-sortable">
                    @foreach($module->fields as $field)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0" data-id="{{ $field->id }}">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-grip-vertical text-muted" style="cursor:grab"></i>
                            <div>
                                <span class="fw-semibold">{{ $field->label }}</span>
                                <code class="ms-1 small">{{ $field->field_name }}</code>
                                <span class="badge bg-light text-dark ms-1">{{ $field->type->value }}</span>
                                @if($field->is_required)  <span class="badge bg-danger ms-1">Required</span>  @endif
                                @if($field->is_searchable)<span class="badge bg-info ms-1">Search</span>     @endif
                                @if($field->is_filterable)<span class="badge bg-secondary ms-1">Filter</span> @endif
                            </div>
                        </div>
                        <form action="{{ route('module-builder.fields.destroy', [$module, $field]) }}" method="POST"
                              onsubmit="return confirm('Remove field \'{{ $field->field_name }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Reorder via fetch on drag-drop (requires SortableJS if installed)
    // Minimal demo: no external lib required
    document.addEventListener('DOMContentLoaded', () => {
        const list = document.getElementById('fields-sortable');
        if (!list) return;
        let dragSrc = null;
        list.querySelectorAll('li').forEach(item => {
            item.setAttribute('draggable', true);
            item.addEventListener('dragstart', e => { dragSrc = item; item.classList.add('opacity-50'); });
            item.addEventListener('dragend',   e => { item.classList.remove('opacity-50'); });
            item.addEventListener('dragover',  e => { e.preventDefault(); });
            item.addEventListener('drop', e => {
                e.preventDefault();
                if (dragSrc !== item) {
                    const items = [...list.children];
                    const from  = items.indexOf(dragSrc);
                    const to    = items.indexOf(item);
                    if (from < to) list.insertBefore(dragSrc, item.nextSibling);
                    else           list.insertBefore(dragSrc, item);

                    // Send new order to server
                    const ids = [...list.children].map(el => el.dataset.id);
                    fetch('{{ route('module-builder.fields.reorder', $module) }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ ids }),
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection
