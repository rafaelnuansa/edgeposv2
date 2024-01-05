<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class BranchController extends Controller
{
    public function index()
    {
        // Retrieve branches associated with the authenticated user
        $branches = Auth::user()->branches;

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'taxable' => 'boolean',
                'tax_id' => 'nullable|numeric',
            ]);

            // Use a transaction to ensure data integrity
            DB::beginTransaction();

            // Create a new branch and associate it with the authenticated user
            Auth::user()->branches()->create($request->all());

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollback();

            // Handle the exception as needed, for example, log it or display an error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function show($id)
    {
        // Decrypt the encrypted id parameter
        $decryptedId = Crypt::decrypt($id);

        // Retrieve the branch associated with the authenticated user using the decrypted id
        $branch = Auth::user()->branches()->findOrFail($decryptedId);
        return view('branches.show', compact('branch'));
    }

    public function edit($id)
    {
        // Decrypt the encrypted id parameter
        $decryptedId = Crypt::decrypt($id);

        // Retrieve the branch associated with the authenticated user using the decrypted id
        $branch = Auth::user()->branches()->findOrFail($decryptedId);

        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'taxable' => 'boolean',
            'tax_id' => 'nullable|numeric',
        ]);

        // Decrypt the encrypted id parameter
        $decryptedId = Crypt::decrypt($id);
        // Update the branch associated with the authenticated user using the decrypted id
        Auth::user()->branches()->findOrFail($decryptedId)->update($request->all());
        return redirect()->route('branches.index')->with('success', 'Branch updated successfully!');
    }

    public function destroy($id)
    {
        // Delete the branch associated with the authenticated user
        Auth::user()->branches()->findOrFail($id)->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully!');
    }
}
