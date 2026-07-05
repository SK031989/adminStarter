<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Module</th>
                <th>Slug</th>
                <th>Fields</th>
                <th>Status</th>
                <th>Generated</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($modules as $module)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-2 bg-primary bg-opacity-10">
                            <i class="bi {{ $module->icon ?? 'bi-grid' }} text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $module->name }}</div>
                            @if($module->description)
                            <div class="text-muted small" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                {{ $module->description }}
                            </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td><code>{{ $module->slug }}</code></td>
                <td>
                    <span class="badge bg-light text-dark border">{{ $module->fields->count() }} fields</span>
                </td>
                <td>
                    <span class="badge bg-{{ $module->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($module->status) }}
                    </span>
                </td>
                <td>
                    @if($module->is_generated)
                        <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Done</span>
                    @else
                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass me-1"></i>Pending</span>
                    @endif
                </td>
                <td class="text-muted small">{{ $module->created_at?->format('d M Y') }}</td>
                <td class="text-end">
                    @include('module-builder::partials.actions', ['item' => $module])
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                    No modules yet.
                    <a href="{{ route('module-builder.create') }}" class="d-block mt-1 small">Create your first module →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
