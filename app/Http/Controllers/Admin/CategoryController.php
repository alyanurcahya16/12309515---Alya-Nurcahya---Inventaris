<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List categories
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories', [
            'categories' => $categories
        ]);
    }

    // Store category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255|unique:categories,name',
            'division_pj' => 'required',
        ]);

        Category::create($validated);

        return back()->with('success', 'Category added successfully!');
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255|unique:categories,name,' . $category->id,
            'division_pj' => 'required',
        ]);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}