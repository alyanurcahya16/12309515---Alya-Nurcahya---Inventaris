<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        $repairs = Repair::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.repairs', compact('repairs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'item_type' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'status' => 'sometimes|in:pending,in_progress,completed,cancelled'
        ]);

        if (!isset($validated['status'])) {
            $validated['status'] = 'pending';
        }

        Repair::create($validated);

        return redirect()->route('admin.repairs.index')->with('success', 'Permintaan perbaikan berhasil ditambahkan!');
    }

    public function update(Request $request, Repair $repair)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'item_type' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $repair->update($validated);

        return redirect()->route('admin.repairs.index')->with('success', 'Permintaan perbaikan berhasil diperbarui!');
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();
        return redirect()->route('admin.repairs.index')->with('success', 'Permintaan perbaikan berhasil dihapus!');
    }
}
