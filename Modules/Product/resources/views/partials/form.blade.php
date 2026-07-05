{{--
    Shared form partial used by both create.blade.php and edit.blade.php.
    Pass $model for edit mode (pre-fills values).
    Supports old(), existing model values, validation errors, file upload,
    select, checkbox, radio, and boolean fields.
--}}

@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">

    <div class="col-md-6">
        <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $model->name ?? '') }}"
            placeholder="Product Name" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="sku" class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
        <input type="text" name="sku" id="sku"
            class="form-control @error('sku') is-invalid @enderror"
            value="{{ old('sku', $model->sku ?? '') }}"
            placeholder="SKU" required>
        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label for="description" class="form-label fw-semibold">Description </label>
        <textarea name="description" id="description" rows="4"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Description" >{{ old('description', $model->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="price" class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
        <input type="number" name="price" id="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', $model->price ?? '') }}"
            placeholder="Price" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="stock" class="form-label fw-semibold">Stock </label>
        <input type="number" name="stock" id="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', $model->stock ?? '') }}"
            placeholder="Stock" >
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="category" class="form-label fw-semibold">Category </label>
        <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" >
            <option value="">— Select Category —</option>
            @foreach($field_category_options ?? [] as $value => $optLabel)
                <option value="{{ $value }}" {{ old('category', $model->category ?? '') == $value ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>
        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="image" class="form-label fw-semibold">Image </label>
        @if(!empty($model->image))
            <div class="mb-2">
                <img src="{{ asset('storage/' . $model->image) }}" alt="Image" class="img-thumbnail" style="max-height:80px;">
            </div>
        @endif
        <input type="file" name="image" id="image"
            class="form-control @error('image') is-invalid @enderror"
            accept="{{ 'image' === 'image' ? 'image/*' : '*' }}" >
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold d-block">Featured</label>
        <div class="form-check form-switch">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                class="form-check-input @error('is_featured') is-invalid @enderror"
                {{ old('is_featured', $model->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Enable</label>
        </div>
        @error('is_featured') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-6">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            <option value="active"   {{ old('status', $model->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $model->status ?? '')       === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

</div>