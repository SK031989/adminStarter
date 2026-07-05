@extends(auth()->check() ? 'dashboard::layouts.admin' : 'layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="container-fluid py-4" style="max-width: 1000px;">
    
    <div class="mb-4">
        <h1 class="h3 mb-1 fw-bold">Profile Settings</h1>
        <p class="text-muted mb-0">Update your account details, password, and manage account security.</p>
    </div>

    {{-- Flash Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        
        {{-- Profile Info Card --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="fw-bold mb-0">Profile Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('auth.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Avatar Preview & Upload --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <label for="avatar" class="form-label mb-1 fw-semibold">Profile Picture</label>
                                <input type="file" name="avatar" id="avatar" class="form-control form-control-sm @error('avatar') is-invalid @enderror">
                                <div class="form-text small">JPEG, PNG or WEBP. Max 2MB.</div>
                                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @if($user->avatar)
                                <a href="{{ route('auth.profile.avatar.destroy') }}" class="btn btn-sm btn-outline-danger ms-auto" onclick="event.preventDefault(); document.getElementById('delete-avatar-form').submit();">
                                    <i class="bi bi-trash"></i>
                                </a>
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email Address --}}
                        <div class="mb-3">
                            <label for="email" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if(config('auth-module.registration.email_verification', true) && !$user->hasVerifiedEmail())
                                <div class="alert alert-warning py-2 px-3 mt-2 mb-0 border-0 small">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Your email address is unverified.
                                    <a href="{{ route('auth.verify.notice') }}" class="fw-semibold">Verify email now</a>
                                </div>
                            @endif
                        </div>

                        {{-- Phone --}}
                        <div class="mb-4">
                            <label for="phone" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </form>

                    {{-- Separate Hidden Form to Delete Avatar --}}
                    @if($user->avatar)
                        <form id="delete-avatar-form" action="{{ route('auth.profile.avatar.destroy') }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>

            {{-- Recent Activity Log Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="fw-bold mb-0">Login History (Recent 5)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>IP Address</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->loginActivities->take(5) as $activity)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $activity->status === 'success' ? 'success' : 'danger' }}">
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                    <td><code>{{ $activity->ip_address }}</code></td>
                                    <td class="text-muted">{{ $activity->created_at?->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No login history recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Card --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="fw-bold mb-0">Update Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('auth.profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h6 class="fw-bold text-danger mb-0">Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Once you delete your account, all of its resources and data will be permanently deleted. Please enter your password to confirm account deletion.</p>
                    
                    @error('delete_password', 'accountDeletion')
                        <div class="alert alert-danger py-2 px-3 small mb-3 border-0">
                            {{ $message }}
                        </div>
                    @enderror

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Delete Account Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('auth.profile.destroy') }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title text-danger fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <div class="mb-0">
                    <label for="delete_password" class="form-label text-slate-700 dark:text-slate-300 fw-semibold">Password</label>
                    <input type="password" name="delete_password" id="delete_password" class="form-control" placeholder="Enter your password to confirm" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm">Permanently Delete</button>
            </div>
        </form>
    </div>
</div>
@endsection
