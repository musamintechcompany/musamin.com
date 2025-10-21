<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')->latest()->paginate(15);
        return view('management.portal.admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        $store->load('user');
        return view('management.portal.admin.stores.view', compact('store'));
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully!');
    }
}