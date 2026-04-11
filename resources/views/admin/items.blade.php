@extends('layouts.dashboard')

@section('page-title', 'Manage Items')

@section('dashboard-content')
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
                <h5 class="mb-0 fw-bold">Items Table</h5>
                <small class="text-muted">Manage inventory items</small>
            </div>
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                + Add Item
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th width="100" class="text-center">Total</th>
                        <th width="150" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $item->category->name }}</span>
                        </td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-center fw-bold">{{ number_format($item->total) }}</td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editItemModal{{ $item->id }}">
                                Edit
                            </button>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Delete this item?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Item Modal -->
                    <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                                    @csrf 
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
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
                                            <input type="text" 
                                                   name="name" 
                                                   value="{{ old('name', $item->name) }}" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Total Stock</label>
                                            <input type="number" 
                                                   name="total" 
                                                   value="{{ old('total', $item->total) }}" 
                                                   class="form-control @error('total') is-invalid @enderror" 
                                                   required>
                                            @error('total')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                        <td colspan="5" class="text-center text-muted py-5">
                            No items found
                        </td>
                    </tr>
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
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Laptop, Chair, etc." 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Quantity</label>
                        <div class="input-group">
                            <input type="number" 
                                   name="total" 
                                   value="{{ old('total', 10) }}" 
                                   class="form-control @error('total') is-invalid @enderror" 
                                   required>
                            <span class="input-group-text">Unit</span>
                        </div>
                        @error('total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

<!-- @section('scripts')
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
@endsection -->