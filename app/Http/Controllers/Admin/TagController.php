<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('assets')->latest()->paginate(15);
        return view('management.portal.admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('management.portal.admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'description' => 'nullable|string',
        ]);

        Tag::create($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully!');
    }

    public function show(Tag $tag)
    {
        $tag->load('assets');
        return view('management.portal.admin.tags.view', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('management.portal.admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string',
        ]);

        $tag->update($validated);
        return redirect()->route('admin.tags.view', $tag)->with('success', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully!');
    }
}