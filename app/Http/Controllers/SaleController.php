<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branchId = $user->active_branch_id;
        // Check if 'selected_branch' session variable is set
        if (!$branchId) {
            throw new \Exception('Please select a branch first.');
        }

        // Retrieve a list of products or categories to display on the POS page
        // $products = Product::all();
        $products = Product::where('branch_id', $branchId)->latest()->get();

        // $categories = Category::all();
        $categories = Category::where('branch_id',  $branchId)->latest()->get();
        $cartItems = auth()->user()->cart;

        return view('sales.index', compact('products', 'categories', 'cartItems'));
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
                'cashier_id' => $userId,
                'product_id' => $product->id,
                'qty'        => 1, // Default quantity is 1, adjust as needed
                'price'      => $product->price,
            ]);
        }

        // Redirect back or to a specific page after adding to cart
        return redirect()->back()->with('success', 'Product added to cart successfully');
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
        $cartItem = Cart::findOrFail($cartItemId);

        $cartItem->delete();

        // You can return a response or redirect as needed
        // return response()->json(['status' => 'success']);
        return redirect()->back()->with('success', 'Clear item success');
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


}
