<div class="d-flex justify-content-end gap-1">
    @can('products.view')
    <a href="{{ route('products.show', $item) }}"
       class="btn btn-sm btn-outline-info" title="View">
        <i class="bi bi-eye"></i>
    </a>
    @endcan

    @can('products.update')
    <a href="{{ route('products.edit', $item) }}"
       class="btn btn-sm btn-outline-primary" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan

    @can('products.delete')
    <form action="{{ route('products.destroy', $item) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Delete this record?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endcan
</div>