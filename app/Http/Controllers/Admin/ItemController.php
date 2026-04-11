<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the items (Admin view)
     */
    public function index()
{
    // Retrieve items with their categories and active lending count
    $items = Item::with('category')
        ->withCount([
            'lendingDetails as active_lending_count' => function ($q) {
                $q->whereHas('lending', fn($l) => $l->whereNull('return_date'));
            }
        ])
        ->get();

    // Retrieve all categories
    $categories = Category::all();

    // Pass items and categories to the view
    return view('admin.items', compact('items', 'categories'));
}

    /**
     * Store a newly created item in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:255',
            'total'       => 'required|integer|min:0',
        ]);

        Item::create([
            ...$validated,
            'repair' => 0, // default broken items
        ]);

        return back()->with('success', 'Item added successfully!');
    }

    /**
     * Update the specified item in storage
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|max:255',
            'total'          => 'required|integer|min:0',
            'new_broke_item' => 'nullable|integer|min:0',
        ]);

        // Handle broken items
        if (!empty($validated['new_broke_item'])) {
            $validated['repair'] = $item->repair + $validated['new_broke_item'];
        }

        unset($validated['new_broke_item']);

        $item->update($validated);

        return back()->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified item from storage
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }
}