<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

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

    public function print($id)
    {
        $transaction = Transaction::with('details.product')->where('id', $id)->first();

        try {
            // Initialize the printer connector (you need to specify the correct printer path)
            $connector = new WindowsPrintConnector("POS58 Printer");

            // Initialize the printer
            $printer = new Printer($connector);

            // Start printing
            // $logo = EscposImage::load('logo.png', true);
            $date = date($transaction->created_at);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            // $printer->graphics($logo);

            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("EdgePOS Branch.\n");
            $printer->selectPrintMode();
            $printer->text("Shop No. 42.\n");
            $printer->feed();

            /* Title of receipt */
            $printer->setEmphasis(true);
            $printer->text("SALES INVOICE\n");
            $printer->setEmphasis(false);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);

            // Transaction details
            // $printer->setEmphasis(true);
            // $printer->text("Product               Qty   Total\n");
            // $printer->setEmphasis(false);

            $printer -> text("-----------------------------\n");

            foreach ($transaction->details as $detail) {
                $productName = str_pad($detail->product->name, 20);
                $qty = str_pad($detail->qty, 5);
                $total = number_format($detail->qty * $detail->price, 2);
                $price = number_format($detail->price);

                // $printer->initialize();
                // $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("{$productName}");
                $printer->initialize();
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text("{$qty} x BND {$price}");
                $printer->text("\n");

                // $printer->text("$productName $qty $$total\n");
            }

    $printer -> text("-----------------------------\n");


            // Total amount
            $printer->setEmphasis(true);
            $printer->text("Total: {$transaction->total_amount}\n");
            $printer->setEmphasis(false);
            $printer->feed();


            $printer->setEmphasis(true);
            $printer->text($transaction->total_amount);
            $printer->setEmphasis(false);
            $printer->feed();

            $printer->text($transaction->total_amount);
            $printer->selectPrintMode();

            $printer->text("Payment Method: {$transaction->payment_method}");
            $printer->selectPrintMode();
            $printer->text("Status: {$transaction->status}");
            $printer->selectPrintMode();


            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping Edgepos \n");
            // $printer -> text("For trading hours, please visit example.com\n");
            $printer->feed(2);
            $printer->text($date . "\n");

            // Add more printing commands based on your receipt content

            // Cut paper
            $printer->cut();
            $printer->pulse();

            // Close the printer connection
            $printer->close();

            return redirect()->back()->with('success', 'Printed successfully');
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during printing
            return redirect()->back()->with('error', 'Printing failed: ' . $e->getMessage());
        }
    }
}
