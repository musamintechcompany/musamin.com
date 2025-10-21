<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->withCount('assets')->latest()->paginate(15);
        return view('management.portal.admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('management.portal.admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Subcategory::create($validated);
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully!');
    }

    public function show(Subcategory $subcategory)
    {
        $subcategory->load(['category', 'assets']);
        return view('management.portal.admin.subcategories.view', compact('subcategory'));
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::active()->ordered()->get();
        return view('management.portal.admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $subcategory->update($validated);
        return redirect()->route('admin.subcategories.view', $subcategory)->with('success', 'Subcategory updated successfully!');
    }

    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->assets()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete subcategory with existing assets.');
        }
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted successfully!');
    }
}