<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $searchQuery = $request->input('search');

        // Query products with the category relationship and apply search filter if provided
        $products = Product::with('category')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function withPagination(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $searchQuery = $request->input('search');

        $products = Product::with('category')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            })
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json([
            'success' => true,
            'products' => $product
        ]);
    }

    // You can add other methods like store, update, and delete here for full CRUD functionality.
}
