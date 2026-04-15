@extends('layouts.dashboard')

@section('page-title', 'Manage Repair Requests')

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Repair Requests Table</h5>
                <small class="text-muted">Manage customer repair submissions</small>
            </div>
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addRepairModal">
                + Add Repair Request
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Customer</th>
                        <th>Item Type</th>
                        <th>Issue Description</th>
                        <th>Status</th>
                        <th>Request Date</th>
                        <th width="150" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($repairs as $index => $repair)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $repair->customer_name }}</div>
                            <small class="text-muted">{{ $repair->customer_email }}</small><br>
                            <small class="text-muted">{{ $repair->customer_phone }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $repair->item_type }}</span>
                        </td>
                        <td class="text-truncate" style="max-width: 250px;">{{ $repair->issue_description }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'in_progress' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'in_progress' => 'In Progress',
                                    'completed' => 'Completed',
                                    'cancelled' => 'Cancelled'
                                ];
                                $color = $statusColors[$repair->status] ?? 'secondary';
                                $label = $statusLabels[$repair->status] ?? ucfirst($repair->status);
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
                        </td>
                        <td>{{ $repair->created_at ? $repair->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="text-center">
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editRepairModal{{ $repair->id }}">
                                Edit
                            </button>
                            <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus permintaan perbaikan ini?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Repair Modal -->
                    <div class="modal fade" id="editRepairModal{{ $repair->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Repair Request</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.repairs.update', $repair->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" name="customer_name" value="{{ old('customer_name', $repair->customer_name) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer Email</label>
                                            <input type="email" name="customer_email" value="{{ old('customer_email', $repair->customer_email) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer Phone</label>
                                            <input type="text" name="customer_phone" value="{{ old('customer_phone', $repair->customer_phone) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Item Type</label>
                                            <input type="text" name="item_type" value="{{ old('item_type', $repair->item_type) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Issue Description</label>
                                            <textarea name="issue_description" class="form-control" rows="3" required>{{ old('issue_description', $repair->issue_description) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" {{ $repair->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $repair->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $repair->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $repair->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
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
                        <td colspan="7" class="text-center text-muted py-5">
                            <div class="py-5">
                                <i class="bi bi-tools" style="font-size: 48px;"></i>
                                <h5 class="mt-3">No repair requests found</h5>
                                <p class="mb-0">Click the button above to add a new repair request.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(isset($repairs) && method_exists($repairs, 'links'))
    <div class="card-footer bg-white">
        {{ $repairs->links() }}
    </div>
    @endif
</div>

<!-- Add Repair Modal -->
<div class="modal fade" id="addRepairModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Repair Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.repairs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Email <span class="text-danger">*</span></label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Phone <span class="text-danger">*</span></label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Type <span class="text-danger">*</span></label>
                        <input type="text" name="item_type" value="{{ old('item_type') }}" class="form-control" placeholder="e.g., Laptop, Smartphone, Refrigerator" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Issue Description <span class="text-danger">*</span></label>
                        <textarea name="issue_description" class="form-control" rows="3" placeholder="Describe the problem in detail..." required>{{ old('issue_description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <small class="text-muted">Default status is "Pending"</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto show modal if there are validation errors
    @if($errors->any())
        @if(session('edit_repair_fail_id'))
            var myModal = new bootstrap.Modal(document.getElementById('editRepairModal{{ session('edit_repair_fail_id') }}'));
        @else
            var myModal = new bootstrap.Modal(document.getElementById('addRepairModal'));
        @endif
        myModal.show();
    @endif
</script>
@endsection
