{{--
    Field Definition Form Partial
    Used by: edit.blade.php
    Handles adding new fields to a module.
--}}

@if($errors->hasBag('field'))
<div class="alert alert-danger mb-3 small">
    <ul class="mb-0 ps-3">
        @foreach($errors->getBag('field')->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('module-builder.fields.store', $module) }}" method="POST" id="field-form">
    @csrf

    <div class="row g-3">

        {{-- Field Name --}}
        <div class="col-md-6">
            <label for="field_name" class="form-label fw-semibold">
                Field Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="field_name" id="field_name"
                class="form-control @error('field_name') is-invalid @enderror"
                value="{{ old('field_name') }}"
                placeholder="e.g. first_name, email, phone"
                pattern="[a-z][a-z0-9_]*"
                required>
            @error('field_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Lowercase, letters, numbers, underscores only.</div>
        </div>

        {{-- Label --}}
        <div class="col-md-6">
            <label for="field_label" class="form-label fw-semibold">
                Label <span class="text-danger">*</span>
            </label>
            <input type="text" name="label" id="field_label"
                class="form-control @error('label') is-invalid @enderror"
                value="{{ old('label') }}"
                placeholder="e.g. First Name" required>
            @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Type --}}
        <div class="col-md-6">
            <label for="field_type" class="form-label fw-semibold">
                Field Type <span class="text-danger">*</span>
            </label>
            <select name="type" id="field_type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">— Select Type —</option>
                @foreach(\Modules\ModuleBuilder\App\Enums\FieldTypeEnum::options() as $value => $label)
                    <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Validation Rules --}}
        <div class="col-md-6">
            <label for="validation_rules" class="form-label fw-semibold">Validation Rules</label>
            <input type="text" name="validation_rules" id="validation_rules"
                class="form-control @error('validation_rules') is-invalid @enderror"
                value="{{ old('validation_rules') }}"
                placeholder="e.g. min:3|max:255|email">
            @error('validation_rules') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Pipe-separated Laravel validation rules.</div>
        </div>

        {{-- Options (shown only for select/radio/checkbox) --}}
        <div class="col-12" id="options-section" style="display:none">
            <label class="form-label fw-semibold">Options</label>
            <div id="options-container">
                <div class="d-flex gap-2 mb-2 option-row">
                    <input type="text" name="options[]" class="form-control form-control-sm" placeholder="Option value">
                    <button type="button" class="btn btn-sm btn-outline-success add-option">+</button>
                </div>
            </div>
        </div>

        {{-- Placeholder --}}
        <div class="col-md-6">
            <label for="placeholder" class="form-label fw-semibold">Placeholder</label>
            <input type="text" name="placeholder" id="placeholder"
                class="form-control" value="{{ old('placeholder') }}"
                placeholder="Enter placeholder text...">
        </div>

        {{-- Default Value --}}
        <div class="col-md-6">
            <label for="default_value" class="form-label fw-semibold">Default Value</label>
            <input type="text" name="default_value" id="default_value"
                class="form-control" value="{{ old('default_value') }}"
                placeholder="Default value (optional)">
        </div>

        {{-- Checkboxes --}}
        <div class="col-12">
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check">
                    <input type="checkbox" name="is_required" id="is_required" value="1"
                        class="form-check-input" {{ old('is_required') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_required">
                        <span class="badge bg-danger me-1">Required</span>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_searchable" id="is_searchable" value="1"
                        class="form-check-input" {{ old('is_searchable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_searchable">
                        <span class="badge bg-info me-1">Searchable</span>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_filterable" id="is_filterable" value="1"
                        class="form-check-input" {{ old('is_filterable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_filterable">
                        <span class="badge bg-secondary me-1">Filterable</span>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_sortable" id="is_sortable" value="1"
                        class="form-check-input" {{ old('is_sortable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_sortable">
                        <span class="badge bg-primary me-1">Sortable</span>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_nullable" id="is_nullable" value="1"
                        class="form-check-input" checked>
                    <label class="form-check-label" for="is_nullable">
                        <span class="badge bg-light text-dark border me-1">Nullable</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Field
            </button>
        </div>

    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect      = document.getElementById('field_type');
    const optionsSection  = document.getElementById('options-section');
    const optionsContainer = document.getElementById('options-container');

    // Show/hide options section
    typeSelect?.addEventListener('change', function () {
        const needsOptions = ['select', 'radio', 'checkbox'].includes(this.value);
        optionsSection.style.display = needsOptions ? 'block' : 'none';
    });

    // Auto-fill label from field name
    document.getElementById('field_name')?.addEventListener('input', function () {
        const label = document.getElementById('field_label');
        if (!label.value) {
            label.value = this.value
                .replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
        }
    });

    // Add option rows
    optionsContainer?.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-option')) {
            const row = document.createElement('div');
            row.className = 'd-flex gap-2 mb-2 option-row';
            row.innerHTML = `<input type="text" name="options[]" class="form-control form-control-sm" placeholder="Option value">
                             <button type="button" class="btn btn-sm btn-outline-danger remove-option">−</button>`;
            optionsContainer.appendChild(row);
        }
        if (e.target.classList.contains('remove-option')) {
            e.target.closest('.option-row').remove();
        }
    });
});
</script>
@endpush
