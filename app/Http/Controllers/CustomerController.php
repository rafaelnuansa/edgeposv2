<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = auth()->user();
        $branchId = $user->active_branch_id;
        // $customers = Customer::all();
        $customers = Customer::where('branch_id', $branchId)->latest()->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $timestamp = now()->timestamp; // Mengambil timestamp saat ini
        $customer_code = 'CUST' . $timestamp; // Menggabungkan inisial "CUST" dengan timestamp
        return view('customers.create', compact('countries', 'customer_code'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Get the authenticated user and retrieve the active branch ID
            $user = auth()->user();
            $branchId = $user->active_branch_id;

            // Validasi inputan form
            $request->validate([
                'name' => 'required',
                'customer_code' => 'required|unique:customers',
                'email' => 'required|email|unique:customers',
                'phone_number' => 'nullable|numeric',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'postal_code' => 'nullable|numeric',
                'country_id' => 'nullable|exists:countries,id',
                'dob' => 'nullable|date',
                'credit_limit' => 'nullable|numeric',
                // Add other validations as needed
            ]);

            // Create an array with the fields you want to include
            $customerData = [
                'name' => $request->input('name'),
                'customer_code' => $request->input('customer_code'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'country_id' => $request->input('country_id'),
                'dob' => $request->input('dob'),
                'credit_limit' => $request->input('credit_limit'),
                'branch_id' => $branchId,
            ];

            // Create and save the new customer
            Customer::create($customerData);

            return redirect()->route('customers.index')->with('success', 'New Customer created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $decryptId = decrypt($id);
        $customer = Customer::findOrFail($decryptId);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptId = decrypt($id);
        $customer = Customer::findOrFail($decryptId);
        $countries = Country::all();
        return view('customers.edit', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $decryptId = decrypt($id);
        $customer = Customer::findOrFail($decryptId);
        // Validasi inputan form
        $request->validate([
            'name' => 'required',
            'customer_code' => 'required|unique:customers,customer_code,' . $decryptId,
            'email' => 'required|email|unique:customers,email,' . $decryptId,
            'phone_number' => 'nullable|numeric',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|numeric',
            'country_id' => 'nullable|exists:countries,id',
            'dob' => 'nullable|date',
            'credit_limit' => 'nullable|numeric',
        ]);

        // Perbarui data customer
        $customer = Customer::findOrFail($decryptId);
        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $decryptId = decrypt($id);
        $customer = Customer::findOrFail($decryptId);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
