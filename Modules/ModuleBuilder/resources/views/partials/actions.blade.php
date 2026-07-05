<div class="d-flex justify-content-end gap-1 flex-wrap">

    {{-- View --}}
    @can('view', $item)
    <a href="{{ route('module-builder.show', $item) }}"
       class="btn btn-sm btn-outline-info" title="View Module">
        <i class="bi bi-eye"></i>
    </a>
    @endcan

    {{-- Edit --}}
    @can('update', $item)
    <a href="{{ route('module-builder.edit', $item) }}"
       class="btn btn-sm btn-outline-primary" title="Edit Module">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan

    {{-- Generate --}}
    @can('update', $item)
    @if(!$item->is_generated)
    <form action="{{ route('module-builder.generate', $item) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Generate all files for {{ addslashes($item->name) }}?')">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-success" title="Generate Module Files">
            <i class="bi bi-lightning"></i>
        </button>
    </form>
    @else
    <span class="btn btn-sm btn-success disabled" title="Already Generated">
        <i class="bi bi-check-circle"></i>
    </span>
    @endif
    @endcan

    {{-- Delete --}}
    @can('delete', $item)
    <form action="{{ route('module-builder.destroy', $item) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Permanently delete module \'{{ addslashes($item->name) }}\'?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Module">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endcan

</div>
