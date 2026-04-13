<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();

        return view('operator.items', compact('items'));
    }

    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'items-' . now()->format('Ymd') . '.xlsx');
    }

    public function exportPdf()
    {
        $items = Item::with('category')->get();
        $pdf = Pdf::loadView('operator.exports.items-pdf', compact('items'));
        return $pdf->download('items-' . now()->format('Ymd') . '.pdf');
    }
}
