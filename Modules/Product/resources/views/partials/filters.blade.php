<form method="GET" action="{{ route('products.index') }}" class="card border-0 shadow-sm mb-3">
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


            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Price</label>
                <input type="text" name="price" class="form-control"
                       placeholder="Price" value="{{ request('price') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Stock</label>
                <input type="text" name="stock" class="form-control"
                       placeholder="Stock" value="{{ request('stock') }}">
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

            {{-- Buttons --}}
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>