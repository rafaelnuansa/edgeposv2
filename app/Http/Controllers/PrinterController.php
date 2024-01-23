<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Printer;
use Illuminate\Validation\ValidationException;

class PrinterController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branchId = $user->active_branch_id;

        $printers = Printer::where('branch_id', $branchId)->latest()->get();
        return view('printers.index', compact('printers'));
    }

    public function create(Request $request)
    {
        return view('printers.create');
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'is_active' => 'boolean',
            ]);

            // dd($request->name);
            // Retrieve the selected branch ID from the session
            $user = auth()->user();
            $branchId = $user->active_branch_id;
            // dd($branchId);
            // Create a new Printer instance with the specified attributes
            $printer = new Printer([
                'name' => $request->name,
                'is_active' => $request->input('is_active', false),
                'branch_id' => $branchId,
            ]);

            // Save the new Printer instance to the database
            $printer->save();

            return redirect()->route('printers.index')->with('success', 'Printer created successfully.');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->route('printers.index')->with('error', 'Failed to create printer: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $printer = Printer::findOrFail($id);
        return view('printers.show', compact('printer'));
    }

    public function edit($id)
    {
        $printer = Printer::findOrFail($id);
        return view('printers.edit', compact('printer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'is_active' => 'boolean',
        ]);

        $printer = Printer::findOrFail($id);
        $printer->update($request->all());

        return redirect()->route('printers.index')->with('success', 'Printer updated successfully.');
    }

    public function destroy($id)
    {
        $printer = Printer::findOrFail($id);
        $printer->delete();

        return redirect()->route('printers.index')->with('success', 'Printer deleted successfully.');
    }
}
