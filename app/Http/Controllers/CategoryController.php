<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Decrypt the branch ID before fetching categories
            $branchId = Crypt::decrypt(session('selected_branch'));
            $categories = Category::where('branch_id', $branchId)->get();
            return view('categories.index', compact('categories'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle decryption exception
            return redirect()->back()->with('error', 'Please select Branch first.');
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getCategories()
{
    try {
        // Decrypt the branch ID before fetching categories
        $branchId = Crypt::decrypt(session('selected_branch'));
        $categories = Category::where('branch_id', $branchId)->get();
        
        // Return categories in JSON format
        return Response::json([
            'success' => true,
            'categories' => $categories,
        ]);
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        // Handle decryption exception
        return Response::json([
            'success' => false,
            'message' => 'Please select a branch first.',
        ], 400);
    } catch (\Exception $e) {
        // Handle general exceptions
        return Response::json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:categories',
            ]);

            // Decrypt the branch ID before creating the category
            $branchId = Crypt::decrypt(session('selected_branch'));

            Category::create([
                'name' => $request->input('name'),
                'branch_id' => $branchId,
            ]);

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (QueryException $e) {
            // Handle unique constraint violation
            return redirect()->back()->with('error', 'Category name must be unique.');
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|unique:categories,name,' . $id,
            ]);

            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->input('name'),
            ]);

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (QueryException $e) {
            // Handle unique constraint violation
            return redirect()->back()->with('error', 'Category name must be unique.');
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'An error occurred while updating the category.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
