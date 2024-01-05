<?php
// app/Http/Controllers/CountryController.php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CountryController extends Controller
{
    public function index()
    {
            $countries = Country::orderBy('name', 'ASC')->paginate(10);
            return view('countries.index', compact('countries'));

    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|unique:countries',
                'name' => 'required|string',
            ]);

            Country::create($request->all());

            return redirect()->route('countries.index')
                ->with('success', 'Country created successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred.']);
        }
    }

    public function show(string $id)
    {
        try {
            $country = Country::findOrFail($id);
            return view('countries.show', compact('country'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred.']);
        }
    }

    public function edit(string $id)
    {
        try {
            $country = Country::findOrFail($id);
            return view('countries.edit', compact('country'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred.']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'code' => 'required|string|unique:countries,code,' . $id,
                'name' => 'required|string',
            ]);

            $country = Country::findOrFail($id);
            $country->update($request->all());

            return redirect()->route('countries.index')
                ->with('success', 'Country updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return redirect()->route('countries.index')
                ->with('success', 'Country deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred.']);
        }
    }
}
