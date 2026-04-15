<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Lending;
use App\Models\Item;
use App\Models\LendingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    public function index()
    {
        $lendings = Lending::with('lendingDetails.item')->orderBy('created_at', 'desc')->get();
        $items = Item::all();

        return view('operator.lendings', compact('lendings', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
            'user' => 'required|string|max:255',
            'note' => 'nullable|string',
            'datetime' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $lending = Lending::create([
                'user' => $request->user,
                'note' => $request->note,
                'datetime' => $request->datetime,
                'returned' => false,
                'edited_by' => auth()->user()->name ?? 'operator',
            ]);

            foreach ($request->items as $item) {
                LendingDetail::create([
                    'lending_id' => $lending->id,
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty'],
                ]);

                $itemModel = Item::find($item['item_id']);
                $itemModel->decrement('total', $item['qty']);
            }

            DB::commit();

            return redirect()->route('operator.lendings.index')
                ->with('success', 'Lending added successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to add lending: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function returnLending($id)
    {
        DB::beginTransaction();

        try {
            $lending = Lending::findOrFail($id);

            foreach ($lending->lendingDetails as $detail) {
                $detail->item->increment('total', $detail->qty);
            }

            $lending->update([
                'returned' => true,
                'return_date' => now(),
                'edited_by' => auth()->user()->name ?? 'operator',
            ]);

            DB::commit();

            return redirect()->route('operator.lendings.index')
                ->with('success', 'Item returned successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to return item: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $lending = Lending::findOrFail($id);

            if (!$lending->returned) {
                foreach ($lending->lendingDetails as $detail) {
                    $detail->item->increment('total', $detail->qty);
                }
            }

            $lending->lendingDetails()->delete();
            $lending->delete();

            DB::commit();

            return redirect()->route('operator.lendings.index')
                ->with('success', 'Lending record deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete lending: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        $lendings = Lending::with('lendingDetails.item')->orderBy('created_at', 'desc')->get();

        $filename = 'lendings_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($lendings) {
    $handle = fopen('php://output', 'w');

    // UTF-8 BOM untuk Excel
    fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

    // Gunakan semicolon sebagai delimiter (locale Indonesia/Eropa)
    fputcsv($handle, ['ID', 'User', 'Note', 'Date', 'Returned', 'Return Date', 'Items'], ';');

    foreach ($lendings as $lending) {
        $items = $lending->lendingDetails->map(function ($detail) {
            return $detail->item->name . ' (x' . $detail->qty . ')';
        })->implode(', ');

        fputcsv($handle, [
            $lending->id,
            $lending->user,
            $lending->note,
            $lending->datetime,
            $lending->returned ? 'Yes' : 'No',
            $lending->return_date ?? '-',
            $items,
        ], ';');
    }

    fclose($handle);
};

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $lendings = Lending::with('lendingDetails.item')->orderBy('created_at', 'desc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.exports.lendings-pdf', compact('lendings'));

        return $pdf->download('lendings_' . now()->format('Ymd_His') . '.pdf');
    }
}
