<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Welcome;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $welcomes = Welcome::latest()->paginate(15);
        return view('management.portal.admin.welcomes.index', compact('welcomes'));
    }

    public function create()
    {
        return view('management.portal.admin.welcomes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'explore_link' => 'nullable|url',
            'text_color' => 'nullable|string|max:7',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('welcome-images', 'public');
        }

        Welcome::create($validated);
        return redirect()->route('admin.welcomes.index')->with('success', 'Welcome message created successfully!');
    }

    public function show(Welcome $welcome)
    {
        return view('management.portal.admin.welcomes.view', compact('welcome'));
    }

    public function edit(Welcome $welcome)
    {
        return view('management.portal.admin.welcomes.edit', compact('welcome'));
    }

    public function update(Request $request, Welcome $welcome)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'explore_link' => 'nullable|url',
            'text_color' => 'nullable|string|max:7',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('welcome-images', 'public');
        }

        $welcome->update($validated);
        return redirect()->route('admin.welcomes.view', $welcome)->with('success', 'Welcome message updated successfully!');
    }

    public function destroy(Welcome $welcome)
    {
        $welcome->delete();
        return redirect()->route('admin.welcomes.index')->with('success', 'Welcome message deleted successfully!');
    }
}