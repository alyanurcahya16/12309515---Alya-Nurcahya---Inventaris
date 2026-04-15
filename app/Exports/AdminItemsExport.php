<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminItemsExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $items;
    protected $repairCounts;

    public function __construct($items, $repairCounts)
    {
        $this->items = $items;
        $this->repairCounts = $repairCounts;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->items as $index => $item) {
            $repairCount = $this->repairCounts[$item->category->name] ?? 0;
            $activeLending = $item->active_lending_count ?? 0;

            $data[] = [
                'no' => $index + 1,
                'category' => $item->category->name,
                'item_name' => $item->name,
                'total_stock' => $item->total,
                'repair_count' => $repairCount,
                'active_lending' => $activeLending,
                'status' => $activeLending > 0 ? 'Dipinjam' : ($item->total > 0 ? 'Tersedia' : 'Habis'),
            ];
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Nama Item',
            'Total Stok',
            'Jumlah Perbaikan',
            'Sedang Dipinjam',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:G1' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 25,
            'D' => 12,
            'E' => 18,
            'F' => 18,
            'G' => 15,
        ];
    }
}
