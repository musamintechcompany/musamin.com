<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::latest()->paginate(15);
        return view('management.portal.admin.currencies.index', compact('currencies'));
    }

    public function show(Currency $currency)
    {
        return view('management.portal.admin.currencies.view', compact('currency'));
    }

    public function create()
    {
        return view('management.portal.admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:currencies',
            'symbol' => 'required|string|max:5'
        ]);

        Currency::create($request->only(['name', 'code', 'symbol']));

        return redirect()->route('admin.currencies.index')->with('success', 'Currency created successfully.');
    }

    public function edit(Currency $currency)
    {
        return view('management.portal.admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:currencies,code,' . $currency->id,
            'symbol' => 'required|string|max:5'
        ]);

        $currency->update($request->only(['name', 'code', 'symbol']));

        return redirect()->route('admin.currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('admin.currencies.index')->with('success', 'Currency deleted successfully.');
    }
}