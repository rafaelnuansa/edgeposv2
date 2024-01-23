<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException; // Import the ValidationException class

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get all transactions from the latest with pagination
        $transactions = Transaction::with('details.product')->latest()->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Transactions retrieved successfully',
            'data' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data for the transaction
            $validatedData = $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
                'cash' => 'required',
                'change' => 'required',
                'discount' => 'required',
                'total_amount' => 'required',
                'payment_method' => 'required',
                'remaining_amount' => 'required|numeric',
                'status' => 'required|string',
                'transaction_details' => 'required|array',
            ]);

            // Generate a unique invoice ID
            $invoice = 'INV-' . Str::random(8);

            // Add the generated invoice ID to the validated data
            $validatedData['invoice'] = $invoice;

            // Create a new transaction instance
            $transaction = new Transaction($validatedData);
            $transaction->cashier_id = auth()->guard('api')->user()->id;

            // Save the transaction to the database
            $transaction->save();

            // Add transaction details if provided in the request
            if ($request->has('transaction_details')) {
                $transactionDetails = $request->input('transaction_details');

                foreach ($transactionDetails as $detail) {
                    $transactionDetail = new TransactionDetail([
                        'transaction_id' => $transaction->id,
                        'product_id' => $detail['product_id'],
                        'qty' => $detail['qty'],
                        'price' => $detail['price'],
                    ]);

                    // Save the transaction detail to the database
                    $transactionDetail->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
