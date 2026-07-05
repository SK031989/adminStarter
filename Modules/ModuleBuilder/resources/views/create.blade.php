@extends('module-builder::layouts.app')

@section('title', 'Create New Module')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-0">Create New Module</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('module-builder.index') }}">Modules</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('module-builder.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom py-3">
        <span class="fw-semibold">Module Definition</span>
        <small class="text-muted ms-2">Fields can be added after creation</small>
    </div>
    <div class="card-body">
        <form action="{{ route('module-builder.store') }}" method="POST" id="create-module-form">
            @csrf
            @include('module-builder::partials.form')
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Create Module
                </button>
                <a href="{{ route('module-builder.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

{{-- Info Card --}}
<div class="card border-0 shadow-sm mt-3 border-start border-primary border-4">
    <div class="card-body">
        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1 text-primary"></i> What happens next?</h6>
        <ul class="mb-0 ps-3 small text-muted">
            <li>The module definition is saved to the database.</li>
            <li>You'll be redirected to add fields to your module.</li>
            <li>Once fields are added, click <strong>Generate</strong> to create all files.</li>
            <li>Generated files include: Model, Controller, Requests, Migration, Routes, and Blade Views.</li>
        </ul>
    </div>
</div>
@endsection
