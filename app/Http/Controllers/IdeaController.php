<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

class IdeaController extends Controller
{
    public function index()
    {
        return view('ideas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'custom_category' => 'nullable|string|max:100',
            'description' => 'required|string|min:10',
            'benefits' => 'nullable|string',
            'media.*' => 'nullable|file|max:15360|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx'
        ]);

        $mediaFiles = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('ideas/media', 'public');
                $mediaFiles[] = $path;
            }
        }

        $idea = Idea::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'custom_category' => $request->custom_category,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'media_files' => $mediaFiles,
            'hashid' => Hashids::encode(time() . rand(1000, 9999))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Idea submitted successfully!',
            'idea_id' => $idea->id
        ]);
    }
}