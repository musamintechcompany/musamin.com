<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::with('user')->latest()->paginate(15);
        return view('management.portal.admin.ideas.index', compact('ideas'));
    }

    public function view(Idea $idea)
    {
        $idea->load('user');
        return view('management.portal.admin.ideas.view', compact('idea'));
    }

    public function markSeen(Idea $idea)
    {
        $idea->update(['status' => 'seen']);
        return redirect()->back()->with('success', 'Idea marked as seen!');
    }

    public function destroy(Idea $idea)
    {
        // Delete associated media files
        if ($idea->media_files) {
            foreach ($idea->media_files as $file) {
                \Storage::disk('public')->delete($file);
            }
        }
        
        $idea->delete();
        return redirect()->route('admin.ideas.index')->with('success', 'Idea deleted successfully!');
    }
}