@extends('layouts.dashboard')

@section('page-title', 'Items')

@section('dashboard-content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Items Table</h5>
                <small class="text-muted">View inventory & availability</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('operator.items.export.excel') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="{{ route('operator.items.export.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Lending Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-light text-dark">{{ $item->category->name ?? '-' }}</span></td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->total }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->available > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->available }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $item->active_lending_count }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No items found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
