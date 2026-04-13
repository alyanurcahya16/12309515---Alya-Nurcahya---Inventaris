<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LendingsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Lending::with('item')->get()->map(function ($l, $index) {
            return [
                'no'          => $index + 1,
                'item'        => $l->item->name ?? '-',
                'total'       => $l->total,
                'borrower'    => $l->user,
                'note'        => $l->note ?? '-',
                'datetime'    => $l->datetime ? \Carbon\Carbon::parse($l->datetime)->format('d M Y, H:i') : '-',
                'returned'    => $l->returned
                                    ? \Carbon\Carbon::parse($l->return_date)->format('d M Y, H:i')
                                    : 'Not Returned',
                'edited_by'   => $l->edited_by ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['#', 'Item', 'Total', 'Borrower', 'Note', 'Date & Time', 'Returned', 'Edited By'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
