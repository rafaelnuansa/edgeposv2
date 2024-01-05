<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class SaleController extends Controller
{
    public function index()
    {
        // Retrieve a list of products or categories to display on the POS page
        $products = Product::all();
        $categories = Category::all();

        return view('sales.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Additional logic for creating a sale (if needed)
        return view('sales.create');
    }

    public function store(Request $request)
    {
        // Additional logic for storing a sale in the database (if needed)
        // You may want to create a new model for sales and handle the logic here

        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
    }
}
