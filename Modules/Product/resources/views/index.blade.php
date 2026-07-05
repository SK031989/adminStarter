@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', 'Product — List')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">{{ __('Product') }}</h1>
            <p class="text-muted mb-0 small">Manage all Product records</p>
        </div>
        @can('products.create')
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Product
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
    @include('products::partials.filters')

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @include('products::partials.table', ['products' => $products])
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} records
        </small>
        {{ $products->withQueryString()->links() }}
    </div>

</div>
@endsection