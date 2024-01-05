<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product; // Pastikan Anda mengimpor model Product
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */

    public function index(Request $request)
    {
        try {
            // Check if 'selected_branch' session variable is set
            if (!Session::has('selected_branch')) {
                throw new \Exception('Please select a branch first.');
            }
            // Decrypt the branch ID before fetching products
            $branchId = Crypt::decrypt(session('selected_branch'));
            if ($request->ajax()) {
                // Fetch only products associated with the selected branch
                $products = Product::where('branch_id', $branchId)->latest()->get();
                return DataTables::of($products)
                    ->addColumn('actions', function ($product) {
                        return view('products.actions', compact('product'))->render();
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            return view('products.index');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle decryption exception
            return redirect()->back()->with('error', 'Failed to decrypt branch ID.');
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Menampilkan formulir untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:products',
                'barcode' => 'nullable|string|max:50',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'cost' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Extract individual attributes from the request
            $name = $request->input('name');
            $code = $request->input('code');
            $barcode = $request->input('barcode');
            $description = $request->input('description');
            $price = $request->input('price');
            $cost = $request->input('cost');
            $stock = $request->input('stock');
            $category_id = $request->input('category_id');

            // Hash the image name and store it
            $newImageName = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/products', $newImageName);

            // Create the product with explicit attributes
            Product::create([
                'name' => $name,
                'code' => $code,
                'barcode' => $barcode,
                'description' => $description,
                'price' => $price,
                'cost' => $cost,
                'image' => $newImageName,
                'stock' => $stock,
                'category_id' => $category_id,
                'branch_id' => Crypt::decrypt(session('selected_branch')),
            ]);

            return redirect()->route('products.index')
                ->with('success', 'Product created.');
        } catch (QueryException $e) {
            return redirect()->route('products.create')
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Menampilkan detail produk.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan formulir untuk mengedit produk.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Mengupdate produk yang ada di database.
     */
    public function update(Request $request, Product $product)
    {
        try {
            // Validasi data yang dikirimkan
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:products,code,' . $product->id,
                'barcode' => 'nullable|string|max:50',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0', // Harga tidak boleh negatif
                'cost' => 'required|numeric|min:0', // Biaya tidak boleh negatif
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar dengan format yang diizinkan
                'stock' => 'required|integer|min:0', // Stok tidak boleh negatif
                'category_id' => 'required|exists:categories,id',
            ]);

            // Periksa jika ada gambar yang diunggah
            if ($request->file('image')) {

                // Hapus gambar lama jika ada
                if ($product->image) {
                    Storage::delete('public/products/' . $product->image);
                }

                // Simpan gambar baru
                $image = $request->file('image');
                $image->storeAs('public/products', $image->hashName());
                $product->image = $image->hashName();
            }

            // Update data produk
            $product->name = $request->input('name');
            $product->code = $request->input('code');
            $product->barcode = $request->input('barcode');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->cost = $request->input('cost');
            $product->stock = $request->input('stock');
            $product->category_id = $request->input('category_id');
            $product->branch_id = Crypt::decrypt(session('selected_branch'));
            $product->save();

            return redirect()->route('products.index')
                ->with('success', 'Product updated.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('products.edit', $product->id)
                ->with('error', 'Product not found.');
        } catch (QueryException $e) {
            return redirect()->route('products.edit', $product->id)
                ->with('error', 'Failed to update product. ' . $e->getMessage());
        }
    }



    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'Product Deleted.');
        } catch (QueryException $e) {
            return redirect()->route('products.index')
                ->with('error', 'Failed to delete. ' . $e->getMessage());
        }
    }
}
