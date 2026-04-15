<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Repair;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminItemsExport; // Gunakan export khusus admin

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')
            ->withCount([
                'lendingDetails as active_lending_count' => function ($q) {
                    $q->whereHas('lending', fn($l) => $l->whereNull('return_date'));
                }
            ])
            ->get();

        $categories = Category::all();
        $repairs = Repair::orderBy('created_at', 'desc')->get();

        // Hitung repair count per kategori
        $repairCounts = [];
        foreach ($repairs as $repair) {
            $categoryName = $repair->item_type;
            if (!isset($repairCounts[$categoryName])) {
                $repairCounts[$categoryName] = 0;
            }
            $repairCounts[$categoryName]++;
        }

        return view('admin.items', compact('items', 'categories', 'repairs', 'repairCounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:0'
        ]);

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil ditambahkan!');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:0'
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil diperbarui!');
    }

   public function destroy(Item $item)
{
    $item->lendingDetails()->delete();
    $item->delete();

    return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus!');
}

    // Export to Excel (Admin)
    public function exportExcel()
    {
        $items = Item::with('category')
            ->withCount([
                'lendingDetails as active_lending_count' => function ($q) {
                    $q->whereHas('lending', fn($l) => $l->whereNull('return_date'));
                }
            ])
            ->get();

        $repairs = Repair::all();

        // Hitung repair count per kategori
        $repairCounts = [];
        foreach ($repairs as $repair) {
            $categoryName = $repair->item_type;
            if (!isset($repairCounts[$categoryName])) {
                $repairCounts[$categoryName] = 0;
            }
            $repairCounts[$categoryName]++;
        }

        return Excel::download(new AdminItemsExport($items, $repairCounts), 'admin-items-export-' . date('Y-m-d') . '.xlsx');
    }

    // Export to PDF (Admin)
    public function exportPdf()
    {
        $items = Item::with('category')
            ->withCount([
                'lendingDetails as active_lending_count' => function ($q) {
                    $q->whereHas('lending', fn($l) => $l->whereNull('return_date'));
                }
            ])
            ->get();

        $repairs = Repair::all();

        $repairCounts = [];
        foreach ($repairs as $repair) {
            $categoryName = $repair->item_type;
            if (!isset($repairCounts[$categoryName])) {
                $repairCounts[$categoryName] = 0;
            }
            $repairCounts[$categoryName]++;
        }

        // KODE INI DITARUH DI SINI (di dalam method exportPdf)
        if (view()->exists('exports.admin-items-pdf')) {
            $pdf = Pdf::loadView('exports.admin-items-pdf', compact('items', 'repairCounts'));
            return $pdf->download('admin-items-export-' . date('Y-m-d') . '.pdf');
        } else {
            // Fallback ke view lain
            $pdf = Pdf::loadView('admin.items-pdf', compact('items', 'repairCounts'));
            return $pdf->download('admin-items-export-' . date('Y-m-d') . '.pdf');
        }
    }
}
