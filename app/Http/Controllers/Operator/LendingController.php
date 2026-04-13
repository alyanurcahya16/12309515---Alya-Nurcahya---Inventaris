<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\LendingsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LendingController extends Controller
{
    public function index()
    {
        $lendings = Lending::with('item')->latest()->get();
        $items = Item::with('category')->get();

        return view('operator.lendings', compact('lendings', 'items'));
    }

   public function store(Request $request)
{
    $request->validate([
        'item_id' => 'required|array',
        'item_id.*' => 'exists:items,id',
        'total' => 'required|array',
        'total.*' => 'integer|min:1',
        'user' => 'required|string',
        'datetime' => 'required|date',
    ]);

    // 1. Simpan lending utama
    $lending = \App\Models\Lending::create([
        'user' => $request->user,
        'note' => $request->note,
        'datetime' => $request->datetime,
    ]);

    // 2. Loop item (INI YANG KAMU TANYA)
    foreach ($request->item_id as $index => $itemId) {
        $total = $request->total[$index];

        \App\Models\LendingDetail::create([
            'lending_id' => $lending->id,
            'item_id' => $itemId,
            'total' => $total,
        ]);
    }

    return redirect()->back()->with('success', 'Lending berhasil ditambahkan');
}


    public function return(Lending $lending)
    {
        $lending->update([
            'returned'    => true,
            'return_date' => now(),
            'edited_by'   => Auth::user()->name . ' (' . Auth::user()->role . ')',
        ]);

        return back()->with('success', 'Item returned successfully!');
    }

    public function destroy(Lending $lending)
    {
        $lending->delete();

        return back()->with('success', 'Lending deleted successfully!');
    }

    public function exportExcel()
    {
        return Excel::download(new LendingsExport, 'lendings-' . now()->format('Ymd') . '.xlsx');
    }

    public function exportPdf()
    {
        $lendings = Lending::with('item')->latest()->get();
        $pdf = Pdf::loadView('operator.exports.lendings-pdf', compact('lendings'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('lendings-' . now()->format('Ymd') . '.pdf');
    }
}
