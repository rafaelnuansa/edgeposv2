<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $greeting = "Welcome";
        $currentTime = now();
        $user = auth()->user();
        $selectedBranch = $user->active_branch_id;
        $branch = encrypt($selectedBranch);
        $branches = $user->branches;


        if ($branch) {
            // Decrypt the branch ID before using it
            $branch = Crypt::decrypt($branch);


            // Calculate net sales
            $netSales = Transaction::where('branch_id', $branch)->sum('total_amount');

            $costOfSales = Transaction::where('branch_id', $branch)
                ->with('details.product') // Eager load the details and related products
                ->get()
                ->pluck('details')
                ->flatten()
                ->sum(function ($detail) {
                    return $detail->qty * $detail->product->cost;
                });

            $customersCounter = Customer::where('branch_id', $branch)->count();
            $productsCounter = Product::where('branch_id', $branch)->count();
            $grossProfit = $netSales - $costOfSales;
            // You can customize this logic based on your application's requirements
            $salesData = [
                'netSales' => $netSales,
                'costOfSales' => $costOfSales,
                'grossProfit' => $grossProfit,
            ];

        } else {
            // Fallback if no branch is selected
            $salesData = [
                'netSales' => 0,
                'costOfSales' => 0,
                'grossProfit' => 0,
            ];
        }

        return view('dashboard.index', compact('greeting', 'currentTime', 'salesData', 'selectedBranch', 'branches'));
    }

    public function selectBranch($branch_id)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Update the user's active branch ID
        $user->update(['active_branch_id' => $branch_id]);
        $user->cart()->delete();
        // Redirect back to the dashboard
        return redirect()->back()->with('success', 'Branch selected successfully!');
    }
}
