<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Item::with('category')->get()->map(function ($item, $index) {
            return [
                'no'            => $index + 1,
                'category'      => $item->category->name ?? '-',
                'name'          => $item->name,
                'total'         => $item->total,
                'available'     => $item->available,
                'lending_total' => $item->active_lending_count,
            ];
        });
    }

    public function headings(): array
    {
        return ['#', 'Category', 'Name', 'Total', 'Available', 'Lending Total'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
