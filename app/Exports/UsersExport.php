<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return User::where('role', 'admin')
            ->select('name', 'email', 'created_at')
            ->get()
            ->map(function ($user, $index) {
                return [
                    'no'         => $index + 1,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'created_at' => $user->created_at->format('d M Y'),
                ];
            });
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Email', 'Created At'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
