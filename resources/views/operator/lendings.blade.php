@extends('layouts.dashboard')

@section('page-title', 'Lendings')

@section('dashboard-content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
                            <th>#</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Name</th>
                            <th>Note</th>
                            <th>Date & Time</th>
                            <th>Returned</th>
                            <th>Edited By</th>
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
                                <td>{{ $l->datetime ? \Carbon\Carbon::parse($l->datetime)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                                </td>

                                {{-- Kolom Returned --}}
                                <td>
                                    @if ($l->returned && $l->return_date)
                                        <span class="badge bg-success">
                                            {{ \Carbon\Carbon::parse($l->return_date)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">Not Returned</span>
                                    @endif
                                </td>

                                {{-- Kolom Edited By --}}
                                <td>{{ $l->edited_by ?? '-' }}</td>

                                {{-- Kolom Action --}}
                                <td>
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
                        <div id="items-wrapper">

                            <div class="item-group border rounded p-3 mb-3 position-relative">

                                {{-- tombol hapus --}}
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-item d-none">
                                    ✕
                                </button>

                                <div class="mb-3">
                                    <label class="form-label">Item Name</label>
                                    <select class="form-select" name="item_id[]" required>
                                        <option value="" disabled selected>Select Item</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }} (Available: {{ $item->available ?? 0 }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Total Quantity</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="total[]" min="1"
                                            value="1" required>
                                        <span class="input-group-text">Unit(s)</span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- tombol tambah --}}
                        <button type="button" id="add-item" class="btn btn-outline-primary w-100 mb-3">
                            + More Item
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
        let index = 1;

        document.getElementById('add-item').addEventListener('click', function() {
            let wrapper = document.getElementById('items-wrapper');

            let html = `
    <div class="item-row mb-3 border p-3 rounded">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Item Name</label>
                <select class="form-select" name="items[${index}][item_id]" required>
                    <option value="">Select Item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }} (Available: {{ $item->available ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Total</label>
                <input type="number" class="form-control" name="items[${index}][total]" min="1" required>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item">X</button>
            </div>
        </div>
    </div>
    `;

            wrapper.insertAdjacentHTML('beforeend', html);
            index++;
        });

        // REMOVE ITEM
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });
    </script>
@endsection
