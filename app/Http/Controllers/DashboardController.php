<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Transaction;
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
        $greeting = "Welcome"; // Customize the greeting as needed
        $currentTime = now(); // Get the current time
        // $selectedBranch = $request->session()->get('selected_branch');
        $user = auth()->user();
        $selectedBranch = $user->active_branch_id;
        $branch = encrypt($selectedBranch);
        // dd($selectedBranch);

        // Fetch the list of branches for the dropdown
        // $branches = Branch::all();
        $branches = $user->branches; // Assuming you have a relationship named 'branches'


        if ($branch) {
            // Decrypt the branch ID before using it
            $branch = Crypt::decrypt($branch);

            // You can customize this logic based on your application's requirements
            $salesData = [
                'netSales' => Transaction::where('branch_id', $branch)->sum('total_amount'),
                'costOfSales' => 0, // Replace with the actual column name
                'grossProfit' => 0, // Replace with the actual column name
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

    public function selectBranch(Request $request)
    {
        // Validate the selected branch ID
        $request->validate([
            'branch_id' => 'required|numeric',
        ]);

        // Retrieve the authenticated user
        $user = auth()->user();

        // Update the user's active branch ID
        $user->update(['active_branch_id' => $request->input('branch_id')]);


        // // Encrypt the branch ID before storing it in the session
        // $encryptedBranchId = Crypt::encrypt($request->input('branch_id'));


        // // Save the encrypted branch ID to the session
        // $request->session()->put('selected_branch', $encryptedBranchId);
        // $request->session()->put('selected_branch_name', Branch::find($request->input('branch_id'))->name);

        // Redirect back to the dashboard
        return redirect()->route('dashboard')->with('success', 'Branch selected successfully!');
    }
}
