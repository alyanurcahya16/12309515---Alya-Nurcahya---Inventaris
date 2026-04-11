@extends('layouts.dashboard')

@section('page-title', 'Item Lending History')

@section('dashboard-content')
<div class="mb-4">
    <div class="card bg-primary text-white">
        <div class="card-body py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <svg class="text-white" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Lending Detail</h4>
                        <p class="text-white text-opacity-75 mb-0 mt-1">
                            Showing all history for item: <strong>{{ $item->name }}</strong>
                        </p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('items.index') }}" class="btn btn-light btn-sm">
                        ← Back to Items
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Lending Table</h5>
                <small class="text-muted">Data of lendings</small>
            </div>
            <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Item</th>
                        <th width="80" class="text-center">Total</th>
                        <th>Borrower</th>
                        <th>Notes</th>
                        <th>Date</th>
                        <th width="100" class="text-center">Status</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lendings as $index => $detail)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-center fw-bold">{{ $detail->qty }}</td>
                        <td>{{ $detail->lending->borrower_name }}</td>
                        <td class="text-muted">{{ $detail->lending->notes ?? '-' }}</td>
                        <td>{{ $detail->lending->borrow_date->format('d M Y') }}</td>
                        <td class="text-center">
                            @if($detail->lending->return_date)
                                <span class="badge bg-success">Returned</span>
                            @else
                                <span class="badge bg-warning text-dark">Not Returned</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $detail->lending->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            No lending history for this item
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection