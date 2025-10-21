<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')->latest()->paginate(15);
        return view('management.portal.admin.states.index', compact('states'));
    }

    public function show(State $state)
    {
        $state->load('country');
        return view('management.portal.admin.states.view', compact('state'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('management.portal.admin.states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        State::create($request->only(['name', 'country_id']));

        return redirect()->route('admin.states.index')->with('success', 'State created successfully.');
    }

    public function edit(State $state)
    {
        $countries = Country::orderBy('name')->get();
        return view('management.portal.admin.states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        $state->update($request->only(['name', 'country_id']));

        return redirect()->route('admin.states.index')->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('admin.states.index')->with('success', 'State deleted successfully.');
    }
}