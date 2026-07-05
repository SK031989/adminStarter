{{--
    Shared Module Form Partial
    Used by: create.blade.php, edit.blade.php
    Pass $model (DynamicModule) for edit mode.
--}}

@if($errors->any())
<div class="alert alert-danger mb-3">
    <ul class="mb-0 ps-3 small">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">

    {{-- Name --}}
    <div class="col-md-7">
        <label for="name" class="form-label fw-semibold">
            Module Name <span class="text-danger">*</span>
        </label>
        <input type="text" name="name" id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $model->name ?? '') }}"
            placeholder="e.g. Employee, Product, Invoice"
            required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Module name in StudlyCase. Will generate class <code>Employee</code>, table <code>employees</code>.</div>
    </div>

    {{-- Icon --}}
    <div class="col-md-5">
        <label for="icon" class="form-label fw-semibold">Bootstrap Icon Class</label>
        <div class="input-group">
            <span class="input-group-text" id="icon-preview">
                <i class="bi {{ old('icon', $model->icon ?? 'bi-grid') }}" id="icon-preview-i"></i>
            </span>
            <input type="text" name="icon" id="icon"
                class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $model->icon ?? 'bi-grid') }}"
                placeholder="bi-grid">
        </div>
        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">
            Find icons at <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a>
        </div>
    </div>

    {{-- Description --}}
    <div class="col-md-12">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea name="description" id="description" rows="2"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Briefly describe this module's purpose...">{{ old('description', $model->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <div class="d-flex gap-3">
            <div class="form-check">
                <input type="radio" name="status" id="status_active" value="active" class="form-check-input"
                    {{ old('status', $model->status ?? 'active') === 'active' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_active">
                    <span class="badge bg-success">Active</span>
                </label>
            </div>
            <div class="form-check">
                <input type="radio" name="status" id="status_inactive" value="inactive" class="form-check-input"
                    {{ old('status', $model->status ?? '') === 'inactive' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_inactive">
                    <span class="badge bg-secondary">Inactive</span>
                </label>
            </div>
        </div>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

</div>

@push('scripts')
<script>
    // Live icon preview
    document.getElementById('icon')?.addEventListener('input', function() {
        const el = document.getElementById('icon-preview-i');
        if (el) {
            el.className = 'bi ' + this.value;
        }
    });
</script>
@endpush
