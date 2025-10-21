<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function index()
    {
        $follows = Follow::with(['follower', 'following'])->latest()->paginate(15);
        return view('management.portal.admin.follows.index', compact('follows'));
    }

    public function show(Follow $follow)
    {
        $follow->load(['follower', 'following']);
        return view('management.portal.admin.follows.view', compact('follow'));
    }

    public function destroy(Follow $follow)
    {
        $follow->delete();
        return redirect()->route('admin.follows.index')->with('success', 'Follow relationship deleted successfully.');
    }
}