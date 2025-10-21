<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinPackage;
use Illuminate\Http\Request;

class CoinPackageController extends Controller
{
    public function index()
    {
        $packages = CoinPackage::latest()->get();
        return view('management.portal.admin.coin-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('management.portal.admin.coin-packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pack_name' => 'required|string|max:50',
            'coins' => 'required|integer|min:1',
            'bonus_coins' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'badge_color' => 'nullable|string|regex:/^#([0-9A-F]{3}){1,2}$/i',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['bonus_coins'] = $data['bonus_coins'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['features'] = array_filter($data['features'] ?? [], fn($feature) => !empty(trim($feature)));

        CoinPackage::create($data);
        return redirect()->route('admin.coin-packages.index')->with('success', 'Coin package created successfully.');
    }

    public function show(CoinPackage $coinPackage)
    {
        return view('management.portal.admin.coin-packages.view', compact('coinPackage'));
    }

    public function edit(CoinPackage $coinPackage)
    {
        return view('management.portal.admin.coin-packages.edit', compact('coinPackage'));
    }

    public function update(Request $request, CoinPackage $coinPackage)
    {
        $request->validate([
            'pack_name' => 'required|string|max:50',
            'coins' => 'required|integer|min:1',
            'bonus_coins' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'badge_color' => 'nullable|string|regex:/^#([0-9A-F]{3}){1,2}$/i',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['bonus_coins'] = $data['bonus_coins'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['features'] = array_filter($data['features'] ?? [], fn($feature) => !empty(trim($feature)));

        $coinPackage->update($data);
        return redirect()->route('admin.coin-packages.index')->with('success', 'Coin package updated successfully.');
    }

    public function destroy(CoinPackage $coinPackage)
    {
        $coinPackage->delete();
        return redirect()->route('admin.coin-packages.index')->with('success', 'Coin package deleted successfully.');
    }
}
