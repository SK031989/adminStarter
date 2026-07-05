@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', 'Product Detail')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Product Detail</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Product</a></li>
                    <li class="breadcrumb-item active">#{{ $product->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @can('products.update')
            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            @endcan
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Detail Card --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom fw-semibold">
                    Product Information
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted">ID</dt>
                        <dd class="col-sm-9">{{ $product->id }}</dd>


                        <dt class="col-sm-3 text-muted">Product Name</dt>
                        <dd class="col-sm-9">{{ ${varName}->name ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">SKU</dt>
                        <dd class="col-sm-9">{{ ${varName}->sku ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Description</dt>
                        <dd class="col-sm-9">{{ ${varName}->description ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Price</dt>
                        <dd class="col-sm-9">{{ ${varName}->price ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Stock</dt>
                        <dd class="col-sm-9">{{ ${varName}->stock ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Category</dt>
                        <dd class="col-sm-9">{{ ${varName}->category ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Image</dt>
                        <dd class="col-sm-9">{{ ${varName}->image ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Featured</dt>
                        <dd class="col-sm-9">{{ ${varName}->is_featured ?? '—' }}</dd>

                        <dt class="col-sm-3 text-muted">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-3 text-muted">Created At</dt>
                        <dd class="col-sm-9">{{ $product->created_at?->format('d M Y, H:i') }}</dd>

                        <dt class="col-sm-3 text-muted">Updated At</dt>
                        <dd class="col-sm-9">{{ $product->updated_at?->format('d M Y, H:i') }}</dd>
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