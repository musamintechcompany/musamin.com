<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetMedia;
use Illuminate\Http\Request;

class AssetMediaController extends Controller
{
    public function index()
    {
        $media = AssetMedia::with('asset')->latest()->paginate(15);
        return view('management.portal.admin.asset-media.index', compact('media'));
    }

    public function show(AssetMedia $assetMedia)
    {
        $assetMedia->load('asset');
        return view('management.portal.admin.asset-media.view', compact('assetMedia'));
    }

    public function destroy(AssetMedia $assetMedia)
    {
        $assetMedia->delete();
        return redirect()->route('admin.asset-media.index')->with('success', 'Media deleted successfully!');
    }
}