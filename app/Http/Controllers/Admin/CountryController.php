<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::withCount('states')->latest()->paginate(15);
        return view('management.portal.admin.countries.index', compact('countries'));
    }

    public function show(Country $country)
    {
        $country->load('states');
        return view('management.portal.admin.countries.view', compact('country'));
    }

    public function create()
    {
        return view('management.portal.admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries',
            'flag' => 'nullable|string|max:10',
            'states' => 'array',
            'states.*' => 'string|max:255'
        ]);

        $country = Country::create($request->only(['name', 'code', 'flag']));

        if ($request->states) {
            foreach ($request->states as $stateName) {
                if (!empty($stateName)) {
                    State::create([
                        'name' => $stateName,
                        'country_id' => $country->id
                    ]);
                }
            }
        }

        return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        $country->load('states');
        return view('management.portal.admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries,code,' . $country->id,
            'flag' => 'nullable|string|max:10',
            'states' => 'array',
            'states.*' => 'string|max:255'
        ]);

        $country->update($request->only(['name', 'code', 'flag']));

        // Update states - simple approach: delete all and recreate
        $country->states()->delete();
        if ($request->states) {
            foreach ($request->states as $stateName) {
                if (!empty($stateName)) {
                    State::create([
                        'name' => $stateName,
                        'country_id' => $country->id
                    ]);
                }
            }
        }

        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully.');
    }
}