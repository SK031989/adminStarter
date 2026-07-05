<form method="GET" action="{{ route('module-builder.index') }}" class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-2 align-items-end">

            {{-- Search --}}
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Name, slug, description..."
                           value="{{ request('search') }}">
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Generated Filter --}}
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Generation</label>
                <select name="generated" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('generated') === '1' ? 'selected' : '' }}>Generated</option>
                    <option value="0" {{ request('generated') === '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'generated']))
                    <a href="{{ route('module-builder.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i> Clear
                    </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</form>
