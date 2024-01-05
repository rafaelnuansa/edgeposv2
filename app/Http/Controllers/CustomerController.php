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
        $customers = Customer::all();
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
                // Tambahkan validasi lain sesuai kebutuhan
            ]);

            // Buat dan simpan customer baru
            Customer::create($request->all());

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $countries = Country::all();
        return view('customers.edit', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi inputan form
        $request->validate([
            'name' => 'required',
            'customer_code' => 'required|unique:customers,customer_code,' . $id,
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone_number' => 'nullable|numeric',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|numeric',
            'country_id' => 'nullable|exists:countries,id',
            'dob' => 'nullable|date',
            'credit_limit' => 'nullable|numeric',
        ]);

        // Perbarui data customer
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
