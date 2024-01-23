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

            $user = auth()->user();
            $branchId = $user->active_branch_id;
            // Check if 'selected_branch' session variable is set
            if (!$branchId) {
                throw new \Exception('Please select a branch first.');
            }
            // Decrypt the branch ID before fetching products
            // dd($branchId);
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

            $user = auth()->user();
            $branchId = $user->active_branch_id;
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
                'branch_id' => $branchId,
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
        $productId = decrypt($id);
        $product = Product::findOrFail($productId);
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan formulir untuk mengedit produk.
     */
    public function edit($id)
    {
        $productId = decrypt($id);
        // dd($productId);
        $product = Product::find($productId);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories', 'id'));
    }

    /**
     * Mengupdate produk yang ada di database.
     */

     public function update(Request $request, $id)
     {

         try {
             // Dekripsi ID produk
             $productId = decrypt($id);
             $product = Product::find($productId);

             // Validasi data yang dikirimkan
             $request->validate([
                 'name' => 'required|string|max:255',
                 'code' => 'required|string|max:50|unique:products,code,' . $productId,
                 'barcode' => 'nullable|string|max:50',
                 'description' => 'nullable|string',
                 'price' => 'required|numeric|min:0',
                 'cost' => 'required|numeric|min:0',
                 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                 'stock' => 'required|integer|min:0',
                 'category_id' => 'required|exists:categories,id',
             ]);

             // Periksa apakah ada gambar yang diunggah
             if ($request->hasFile('image')) {
                 // Hapus gambar lama jika ada
                 if ($product->image) {
                     Storage::delete('public/products/' . $product->image);
                 }

                 // Simpan gambar baru
                 $image = $request->file('image');
                 $imagePath = $image->storeAs('public/products', $image->hashName());
                 $product->image = basename($imagePath);
             }

             $branchId = auth()->user()->active_branch_id;
             // Update data produk
             $product->name = $request->input('name');
             $product->code = $request->input('code');
             $product->barcode = $request->input('barcode');
             $product->description = $request->input('description');
             $product->price = $request->input('price');
             $product->cost = $request->input('cost');
             $product->stock = $request->input('stock');
             $product->category_id = $request->input('category_id');
             $product->branch_id = $branchId;
             $product->save();

             return redirect()->route('products.index')->with('success', 'Product updated.');
         } catch (ModelNotFoundException $e) {
             return redirect()->back()->with('error', 'Product not found.');
         } catch (QueryException $e) {
             return redirect()->back()->with('error', 'Failed to update product. ' . $e->getMessage());
         } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
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
