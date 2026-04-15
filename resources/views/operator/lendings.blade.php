@extends('layouts.dashboard')

@section('page-title', 'Lendings')

@section('dashboard-content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lending List</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('operator.lendings.export.excel') }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('operator.lendings.export.pdf') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLendingModal">
                + Add Lending
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Item(s)</th>
                            <th width="10%">Total Qty</th>
                            <th width="15%">Borrower</th>
                            <th width="15%">Note</th>
                            <th width="15%">Date & Time</th>
                            <th width="10%">Returned</th>
                            <th width="10%">Edited By</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lendings as $index => $l)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    @foreach ($l->lendingDetails as $detail)
                                        {{ $detail->item->name }} ({{ $detail->qty }})<br>
                                    @endforeach
                                </td>
                                <td class="text-center fw-bold text-primary">
                                    {{ $l->lendingDetails->sum('qty') }}
                                </td>
                                <td>{{ $l->user ?? '-' }}</td>
                                <td>{{ $l->note ?? '-' }}</td>
                                <td>
                                    {{ $l->datetime ? \Carbon\Carbon::parse($l->datetime)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($l->returned && $l->return_date)
                                        <span class="badge bg-success">
                                            {{ \Carbon\Carbon::parse($l->return_date)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">Not Returned</span>
                                    @endif
                                </td>
                                <td>{{ $l->edited_by ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if (!$l->returned)
                                            <form action="{{ route('operator.lendings.return', $l->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">Return</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Returned</button>
                                        @endif

                                        <form action="{{ route('operator.lendings.destroy', $l->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this lending record?')">Delete</button>
                                        </form>
                                    </div>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLendingModalLabel">Add New Lending</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('operator.lendings.store') }}" method="POST" id="lendingForm">
                    @csrf
                    <div class="modal-body">
                        <div id="items-wrapper">
                            <div class="item-group border rounded p-3 mb-3" data-index="0">
                                <div class="row align-items-end">
                                    <div class="col-md-7">
                                        <label class="form-label">Item Name</label>
                                        <select class="form-select" name="items[0][item_id]" required>
                                            <option value="" disabled selected>Select Item</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }} (Stock: {{ $item->total }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="items[0][qty]" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-item-btn w-100" style="display: none;">
                                            ✕ Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-item-btn" class="btn btn-outline-primary w-100 mb-3">
                            + Add More Item
                        </button>

                        <div class="mb-3">
                            <label for="user" class="form-label">Borrower Name</label>
                            <input type="text" class="form-control @error('user') is-invalid @enderror" id="user"
                                name="user" value="{{ old('user') }}" placeholder="Enter full name" required>
                            @error('user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note <span class="text-muted">(Optional)</span></label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="2"
                                placeholder="Any additional information...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="datetime" class="form-label">Date & Time</label>
                            <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror"
                                id="datetime" name="datetime" value="{{ old('datetime', date('Y-m-d\TH:i')) }}"
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

@section('scripts')
<script>
    let itemCounter = 1;

    // Add item button
    document.getElementById('add-item-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('items-wrapper');
        const currentIndex = itemCounter;

        const html = `
            <div class="item-group border rounded p-3 mb-3" data-index="${currentIndex}">
                <div class="row align-items-end">
                    <div class="col-md-7">
                        <label class="form-label">Item Name</label>
                        <select class="form-select" name="items[${currentIndex}][item_id]" required>
                            <option value="" disabled selected>Select Item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }} (Stock: {{ $item->total }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="items[${currentIndex}][qty]" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item-btn w-100">✕ Remove</button>
                    </div>
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);

        // Show remove button for all items except the first one
        const allRemoveBtns = document.querySelectorAll('.remove-item-btn');
        allRemoveBtns.forEach(btn => btn.style.display = 'block');

        itemCounter++;
    });

    // Remove item (event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item-btn')) {
            const itemGroup = e.target.closest('.item-group');
            if (itemGroup) {
                itemGroup.remove();
            }

            // Hide remove button if only one item left
            const remainingItems = document.querySelectorAll('.item-group');
            if (remainingItems.length === 1) {
                const removeBtn = remainingItems[0].querySelector('.remove-item-btn');
                if (removeBtn) {
                    removeBtn.style.display = 'none';
                }
            }
        }
    });

    // Debug: Log form data before submit
    document.getElementById('lendingForm').addEventListener('submit', function(e) {
        const items = document.querySelectorAll('.item-group');
        console.log('Total items to submit:', items.length);

        items.forEach((item, idx) => {
            const select = item.querySelector('select');
            const qty = item.querySelector('input[type="number"]');
            console.log(`Item ${idx + 1}:`, {
                item_id: select?.value,
                qty: qty?.value
            });
        });
    });
</script>
@endsection
