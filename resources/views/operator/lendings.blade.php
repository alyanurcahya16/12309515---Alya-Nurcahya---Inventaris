@extends('layouts.dashboard')

@section('page-title', 'Lendings')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Lending List</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLendingModal">+ Add Lending</button>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Name</th>
                        <th>Note</th>
                        <th>Date & Time</th>
                        <th>Returned</th>
                        <th>Edit By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lendings as $index => $l)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $l->item->name ?? '-' }}</td>
                        <td>{{ $l->total ?? '-' }}</td>
                        <td>{{ $l->user ?? '-' }}</td>
                        <td>{{ $l->note ?? '-' }}</td>
                        <td>{{ $l->datetime ?? '-' }}</td>
                        <td>{{ $l->edited_by ?? '-' }}</td>
                        <td>
                            @if(!($l->returned ?? false))
                            <button class="btn btn-success btn-sm">Return</button>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>Returned</button>
                            @endif

                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">No lending records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Lending -->
<div class="modal fade" id="addLendingModal" tabindex="-1" aria-labelledby="addLendingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLendingModalLabel">Add New Lending</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('operator.lendings.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_id" class="form-label">Item Name</label>
                        <select class="form-select @error('item_id') is-invalid @enderror"
                            id="item_id"
                            name="item_id"
                            required>
                            <option value="" disabled {{ old('item_id') ? '' : 'selected' }}>Select Item</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} (Available: {{ ($item->total ?? 0) - ($item->active_lending_count ?? 0) }})
                            </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total" class="form-label">Total Quantity</label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('total') is-invalid @enderror"
                                id="total"
                                name="total"
                                value="{{ old('total', 1) }}"
                                min="1"
                                required>
                            <span class="input-group-text">Unit(s)</span>
                        </div>
                        @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user" class="form-label">Borrower Name</label>
                        <input type="text"
                            class="form-control @error('user') is-invalid @enderror"
                            id="user"
                            name="user"
                            value="{{ old('user') }}"
                            placeholder="Enter full name"
                            required>
                        @error('user')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Note (Optional)</label>
                        <textarea class="form-control @error('note') is-invalid @enderror"
                            id="note"
                            name="note"
                            rows="2"
                            placeholder="Any additional information...">{{ old('note') }}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="datetime" class="form-label">Date & Time</label>
                        <input type="datetime-local"
                            class="form-control @error('datetime') is-invalid @enderror"
                            id="datetime"
                            name="datetime"
                            value="{{ old('datetime', date('Y-m-d\TH:i')) }}"
                            required>
                        @error('datetime')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Lending</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection