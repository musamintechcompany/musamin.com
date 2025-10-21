<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetFavorite;
use Illuminate\Http\Request;

class AssetFavoriteController extends Controller
{
    public function index()
    {
        $favorites = AssetFavorite::with(['user', 'asset'])->latest()->paginate(15);
        return view('management.portal.admin.asset-favorites.index', compact('favorites'));
    }

    public function destroy(AssetFavorite $assetFavorite)
    {
        $assetFavorite->delete();
        return redirect()->route('admin.asset-favorites.index')->with('success', 'Favorite removed successfully!');
    }
}