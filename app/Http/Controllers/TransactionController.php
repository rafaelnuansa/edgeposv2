<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('details.product')->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('details.product')->where('id', $id)->first();

        return view('transactions.show', compact('transaction'));
    }

}
