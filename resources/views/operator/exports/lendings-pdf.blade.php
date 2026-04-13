<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lending List</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #343a40; color: white; padding: 7px 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #dee2e6; }
        tr:nth-child(even) td { background-color: #f8f9fa; }
        .badge-returned { color: #198754; font-weight: bold; }
        .badge-not { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Lending List</h2>
    <p class="sub">Generated on {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Item</th>
                <th width="50">Total</th>
                <th>Borrower</th>
                <th>Note</th>
                <th>Date & Time</th>
                <th>Returned</th>
                <th>Edited By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lendings as $index => $l)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $l->item->name ?? '-' }}</td>
                <td>{{ $l->total }}</td>
                <td>{{ $l->user }}</td>
                <td>{{ $l->note ?? '-' }}</td>
                <td>{{ $l->datetime ? \Carbon\Carbon::parse($l->datetime)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}</td>
                <td>
                    @if($l->returned && $l->return_date)
                        <span class="badge-returned">
                            {{ \Carbon\Carbon::parse($l->return_date)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                        </span>
                    @else
                        <span class="badge-not">Not Returned</span>
                    @endif
                </td>
                <td>{{ $l->edited_by ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center">No lending records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
