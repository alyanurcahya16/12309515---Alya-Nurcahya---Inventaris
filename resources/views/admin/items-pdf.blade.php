<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Items Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4CAF50;
        }
        .header h2 {
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        td {
            text-align: center;
        }
        .text-start {
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .text-success {
            color: green;
            font-weight: bold;
        }
        .text-warning {
            color: orange;
            font-weight: bold;
        }
        .text-danger {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Admin Items Report</h2>
        <p>Generated on: {{ date('d M Y H:i:s') }}</p>
        <p>Total Items: {{ count($items) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Category</th>
                <th width="25%">Item Name</th>
                <th width="12%">Total Stock</th>
                <th width="15%">Repair Count</th>
                <th width="15%">Active Lending</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            @php
                $repairCount = isset($repairCounts[$item->category->name]) ? $repairCounts[$item->category->name] : 0;
                $activeLending = $item->active_lending_count ?? 0;
                $status = $activeLending > 0 ? 'Dipinjam' : ($item->total > 0 ? 'Tersedia' : 'Habis');
                $statusClass = $activeLending > 0 ? 'text-warning' : ($item->total > 0 ? 'text-success' : 'text-danger');
            @endphp
            <tr>
                <td style="text-align: center">{{ $index + 1 }}</td>
                <td class="text-start">{{ $item->category->name }}</td>
                <td class="text-start">{{ $item->name }}</td>
                <td style="text-align: center">{{ number_format($item->total) }}</td>
                <td style="text-align: center">{{ $repairCount }}</td>
                <td style="text-align: center">{{ $activeLending }}</td>
                <td style="text-align: center">
                    <span class="{{ $statusClass }}">{{ $status }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
        <p>&copy; {{ date('Y') }} Inventory Management System</p>
    </div>
</body>
</html>
