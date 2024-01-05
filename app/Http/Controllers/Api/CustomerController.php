<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search'); // Get the search query from the request

        // Start building the query to retrieve customers with eager loading of the 'country' relationship
        $query = Customer::with('country');

        // If a search query is provided, filter the results based on the 'name' attribute
        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Retrieve the customers
        $customers = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Customer data retrieved successfully.',
            'customers' => $customers,
        ], 200);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => 'required|email|unique:customers', // Unique constraint for email
            'phone_number' => 'nullable|numeric',
            'address'      => 'nullable|string',
            'city'         => 'nullable|string',
            'postal_code'  => 'nullable|numeric',
            'country_id'   => 'nullable|exists:countries,id',
            'dob'          => 'nullable|date',
            'credit_limit' => 'nullable|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Generate a customer code based on the current timestamp
        $timestamp = now()->timestamp; // Get the current timestamp
        $customer_code = 'CUST' . $timestamp; // Combine "CUST" with the timestamp

        // Create a new customer instance with the generated customer code
        $customer = new Customer([
            'name'         => $request->input('name'),
            'customer_code' => $customer_code,
            'email'        => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address'      => $request->input('address'),
            'city'         => $request->input('city'),
            'postal_code'  => $request->input('postal_code'),
            'country_id'   => $request->input('country_id'),
            'dob'          => $request->input('dob'),
            'credit_limit' => $request->input('credit_limit'),
        ]);

        // Save the customer instance to the database
        $customer->save();

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Customer data berhasil ditambahkan!',
            'customer' => $customer,
        ], 201); // 201 Created status code
    }

    public function show($id)
    {
        // Find the customer by ID and eager load the 'country' relationship
        $customer = Customer::with('country')->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ], 404); // 404 Not Found status code
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer data retrieved successfully.',
            'customer' => $customer,
        ], 200);
    }
}
