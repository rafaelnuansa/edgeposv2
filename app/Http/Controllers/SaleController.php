<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Hold;
use App\Models\HoldItem;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branchId = $user->active_branch_id;
        $customers = Customer::all();

        // Check if 'selected_branch' session variable is set
        if (!$branchId) {
            return redirect()->route('dashboard')->with('error', 'Please select a branch first');
        }

        // Retrieve a list of products or categories to display on the POS page
        $products = Product::where('branch_id', $branchId)->latest()->get();

        // Retrieve held orders with holdItems
        $heldOrders = Hold::with('holdItems')->where('cashier_id', auth()->id())->get();
        // Count the number of held orders
        $countHeldOrders = $heldOrders->count();

        // $categories = Category::all();
        $categories = Category::where('branch_id',  $branchId)->latest()->get();
        $cartItems = auth()->user()->cart;

        return view('sales.index', compact('products', 'customers', 'categories', 'cartItems', 'heldOrders', 'countHeldOrders'));
    }


    public function fetchCart()
    {
        try {
            $userId = auth()->id();
            $cartItems = Cart::with('product')->where('cashier_id', $userId)->get();

            return new JsonResponse(['cartItems' => $cartItems]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchProductsAndCategories(Request $request)
    {
        $user = auth()->user();
        $branchId = $user->active_branch_id;

        // Check if 'selected_branch' session variable is set
        if (!$branchId) {
            return new JsonResponse(['error' => 'Please select a branch first.'], 400);
        }

        // Retrieve a list of products and categories to display on the POS page
        $query = Product::where('branch_id', $branchId);

        // Handle search query
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // Handle category filtering
        if ($request->has('categories')) {
            $categories = $request->input('categories');
            $query->whereIn('category_id', $categories);
        }

        $products = $query->latest()->get();
        $categories = Category::where('branch_id', $branchId)->latest()->get();

        return new JsonResponse(['products' => $products, 'categories' => $categories]);
    }


    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $userId = auth()->id();

        // Check if the product is already in the cart for the current user
        $existingCartItem = Cart::where('cashier_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existingCartItem) {
            // If the product is already in the cart, increment the quantity
            $existingCartItem->increment('qty');
        } else {
            // If the product is not in the cart, create a new cart item
            Cart::create([
                'cashier_id'  => $userId,
                'product_id'  => $product->id,
                'qty'         => 1, // Default quantity is 1, adjust as needed
                'price'       => $product->price,
            ]);
        }

        // Return a JSON response with success message
        return new JsonResponse(['success' => true, 'message' => 'Product added to cart successfully']);
    }


    public function change_qty(Request $request, $cartItemId)
    {
        $cartItem = Cart::findOrFail($cartItemId);

        $request->validate([
            'qty' => 'required|integer|min:1', // Add any other validation rules you need
        ]);

        $cartItem->update(['qty' => $request->input('qty')]);

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'cart_item' => $cartItem]);
    }

    public function cancel_item($cartItemId)
    {
        try {
            $cartItem = Cart::findOrFail($cartItemId);

            $cartItem->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Handle exception if needed
            return response()->json(['status' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel_cart()
    {
        // Assuming you want to clear the entire cart for the logged-in user
        auth()->user()->cart()->delete();
        // You can return a response or redirect as needed
        return response()->json(['status' => 'success']);
    }


    public function charge()
    {
        // Retrieve the user's cart items
        $cartItems = auth()->user()->cart;

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Cart is empty. Add items before processing the transaction.');
        }

        // Calculate total amount from the cart items
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });

        // Load the customers
        $customers = Customer::all();

        return view('sales.charge', compact('cartItems', 'totalAmount', 'customers'));
    }

    public function proceed(Request $request)
    {
        try {
            DB::beginTransaction();

            // Retrieve the user's cart items
            $cartItems = auth()->user()->cart;

            // Check if the cart is not empty
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Cart is empty. Add items before processing the transaction.');
            }

            // Calculate total amount from the cart items
            $totalAmount = $cartItems->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });

            // Assuming you have a discount logic, apply it here
            $discount = 0; // Implement your discount logic if needed

            // Calculate remaining amount after discount
            $remainingAmount = $totalAmount - $discount;

            // Get the cash provided by the user
            $cashProvided = $request->input('cash');

            // Check if the cash provided is less than the total amount
            if ($cashProvided < $totalAmount) {
                return redirect()->back()->with('error', 'Cash provided must be equal or greater than the total amount.');
            }

            // Calculate the change
            $change = $cashProvided - $remainingAmount;

            // Create a new transaction record
            $transaction = Transaction::create([
                'cashier_id'      => auth()->id(),
                'customer_id'     => null, // Assuming no customer for now
                'branch_id'       => 1, // Replace with the actual branch ID
                'invoice'         => 'INV_' . time(), // You may implement a proper invoice generation logic
                'cash'            => $cashProvided,
                'change'          => $change,
                'payment_method'  => $request->input('payment_method'), // Assuming you have a form field for payment method
                'discount'        => $discount,
                'total_amount'    => $totalAmount,
                'remaining_amount' => $remainingAmount,
                'status'          => 'paid', // Assuming the status should be 'paid' after successful payment
            ]);

            // Create transaction details for each cart item
            foreach ($cartItems as $cartItem) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $cartItem->product_id,
                    'qty'            => $cartItem->qty,
                    'price'          => $cartItem->price,
                ]);
                // Remove the processed cart item
                $cartItem->delete();
            }

            // Clear the cart after a successful transaction
            auth()->user()->cart()->delete();
            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Transaction completed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaction failed' . $e->getMessage());
        }
    }

    public function hold_cart(Request $request)
    {
        // Retrieve the user's cart items
        $cartItems = auth()->user()->cart;

        // Check if the cart is not empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Cart is empty. Add items before holding.');
        }

        try {
            DB::beginTransaction();

            // Get customer ID from the form input, or set it to null if not provided
            $customerId = $request->input('customer_id', null);

            // Create a new hold record
            $hold = Hold::create([
                'cashier_id' => auth()->id(),
                'customer_id' => $customerId,
                'hold_name' => $request->input('hold_name'), // Optional, set to null if not provided
            ]);

            // Create hold items for each cart item
            foreach ($cartItems as $cartItem) {
                HoldItem::create([
                    'hold_id' => $hold->id,
                    'product_id' => $cartItem->product_id,
                    'qty' => $cartItem->qty,
                    'price' => $cartItem->price,
                ]);

                // Remove the cart item as it is now on hold
                $cartItem->delete();
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Cart items held successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hold failed: ' . $e->getMessage());
        }
    }

    public function heldOrders()
    {
        $heldOrders = Hold::where('cashier_id', auth()->id())->get();
        return view('sales.held_orders', compact('heldOrders'));
    }

    public function heldOrderItems($holdId)
    {
        $heldOrder = Hold::findOrFail($holdId);
        $heldItems = HoldItem::where('hold_id', $holdId)->get();

        return view('sales.held_order_items', compact('heldOrder', 'heldItems'));
    }


    public function addCustomer(Request $request)
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

             // Redirect atau kembalikan tanggapan sesuai kebutuhan
    return redirect()->back()->with('success', 'Customer added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function resume_held($holdId)
    {
        try {
            DB::beginTransaction();

            // Find the held order
            $heldOrder = Hold::findOrFail($holdId);

            // Create cart items for each hold item
            foreach ($heldOrder->holdItems as $holdItem) {
                Cart::create([
                    'cashier_id' => auth()->id(),
                    'product_id' => $holdItem->product_id,
                    'qty'        => $holdItem->qty,
                    'price'      => $holdItem->price,
                ]);
            }

            // Delete the hold order and related items
            $heldOrder->holdItems()->delete();
            $heldOrder->delete();

            DB::commit();

            return new JsonResponse(['status' => 'success', 'message' => 'Held order resumed successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return new JsonResponse(['status' => 'error', 'message' => 'Failed to resume held order: ' . $e->getMessage()], 500);
        }
    }

    public function fetchHeldOrders()
    {
        try {
            $user = auth()->user();
            $heldOrders = Hold::with('holdItems')
                ->where('cashier_id', $user->id)
                ->get();

            return new JsonResponse(['status' => 'success', 'heldOrders' => $heldOrders]);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

}
