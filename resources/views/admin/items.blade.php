@extends('layouts.dashboard')

@section('page-title', 'Manage Items')

@section('dashboard-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Items Table</h5>
                    <small class="text-muted">Manage inventory items with repair and lending status</small>
                </div>
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.items.export.excel') }}">
                                <i class="bi bi-file-earmark-excel"></i> Export to Excel
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.items.export.pdf') }}">
                                <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                            </a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        + Add Item
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">
                                <small>#</small>
                            </th>
                            <th class="text-start">
                                <small>Category</small>
                            </th>
                            <th class="text-start">
                                <small>Item Name</small>
                            </th>
                            <th width="110" class="text-center">
                                <small>Total Stock</small>
                            </th>
                            <th width="100" class="text-center">
                                <small>Repair</small>
                            </th>
                            <th width="130" class="text-center">
                                <small>Active Lending</small>
                            </th>
                            <th width="140" class="text-center">
                                <small>Actions</small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                <td class="text-start">
                                    <span class="badge bg-light text-dark">{{ $item->category->name }}</span>
                                </td>
                                <td class="fw-semibold">{{ $item->name }}</td>
                                <td class="text-center fw-bold text-primary">{{ number_format($item->total) }}</td>

                                {{-- Kolom Repair --}}
                                <td class="text-center">
                                    @php
                                        $repairCount = isset($repairCounts[$item->category->name])
                                            ? $repairCounts[$item->category->name]
                                            : 0;
                                    @endphp
                                    @if ($repairCount > 0)
                                        <span class="badge bg-danger">
                                            🔧 {{ $repairCount }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            ✓ 0
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom Active Lending --}}
                                <td class="text-center">
                                    @php
                                        $activeLending = $item->active_lending_count ?? 0;
                                    @endphp
                                    @if ($activeLending > 0)
                                        <span class="badge bg-warning">
                                            📤 {{ $activeLending }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            ✓ Tersedia
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editItemModal{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Delete this item?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            

                            <!-- Edit Item Modal -->
                            <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id"
                                                        class="form-select @error('category_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Item Name</label>
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $item->name) }}"
                                                        class="form-control @error('name') is-invalid @enderror" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Total Stock</label>
                                                    <input type="number" name="total"
                                                        value="{{ old('total', $item->total) }}"
                                                        class="form-control @error('total') is-invalid @enderror" required>
                                                    @error('total')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="py-4">
                                        <i class="bi bi-box" style="font-size: 40px;"></i>
                                        <p class="mb-0 mt-2">No items found</p>
                                    </div>
                                </td>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Register New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.items.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Quantity</label>
                            <input type="number" name="total" value="10" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Submit</button>
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
        @if(session('edit_item_fail_id'))
            var myModal = new bootstrap.Modal(document.getElementById('editItemModal{{ session('edit_item_fail_id') }}'));
        @else
            var myModal = new bootstrap.Modal(document.getElementById('addItemModal'));
        @endif
        myModal.show();
    @endif
</script>
@endsection
