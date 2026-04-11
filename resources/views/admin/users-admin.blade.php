@extends('layouts.dashboard')

@section('page-title', 'Manage Admin Accounts')

@section('dashboard-content')
@if(session('generated_password'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Password Generated!</strong> Login Credential: <code class="bg-dark text-warning px-2 py-1 rounded">{{ session('generated_password') }}</code>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Admin Accounts</h5>
                <small class="text-muted">Manage system privileges</small>
            </div>
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                + Add Admin
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal{{ $user->id }}">
                                Edit
                            </button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Delete this account?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Admin Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf 
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                New Password 
                                                <small class="text-muted">(optional)</small>
                                            </label>
                                            <input type="password" 
                                                   name="password" 
                                                   class="form-control" 
                                                   placeholder="Leave blank to keep current password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            No admin accounts found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Admin Name" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="admin@example.com" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="role" value="admin">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- @section('scripts')
<script>
    // Auto show modal if there are validation errors
    @if($errors->any())
        @if(session('edit_user_fail_id'))
            var myModal = new bootstrap.Modal(document.getElementById('editUserModal{{ session('edit_user_fail_id') }}'));
        @else
            var myModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        @endif
        myModal.show();
    @endif
</script>
@endsection -->