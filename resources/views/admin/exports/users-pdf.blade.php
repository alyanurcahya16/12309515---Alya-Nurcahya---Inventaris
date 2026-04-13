<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Accounts</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #343a40; color: white; padding: 8px; text-align: left; }
        td { padding: 7px 8px; border-bottom: 1px solid #dee2e6; }
        tr:nth-child(even) td { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h2>Admin Accounts</h2>
    <p class="sub">Generated on {{ now()->format('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th width="40">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center">No data found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
