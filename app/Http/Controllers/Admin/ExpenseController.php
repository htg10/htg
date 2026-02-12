<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::query();

        // filter by purpose
        if ($request->filled('purpose')) {
            $expenses->where('purpose', 'like', '%' . $request->purpose . '%');
        }

        // filter by payment mode
        if ($request->filled('payment_mode')) {
            $expenses->where('payment_mode', $request->payment_mode);
        }

        //filter by date
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $expenses->whereBetween('date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $expenses = $expenses->latest()->get();
        // $expenses = Expense::latest()->get();
        $banks = Bank::all();

        // Calculate total amount
        $totalAmount = $expenses->sum('amount');

        return view('admin.expense.index', compact('expenses', 'banks', 'totalAmount'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('admin.expense.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|string',
            'date' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf'
        ]);

        $imagePath = null;

        if ($request->hasFile('attachment')) {
            $fileImage = $request->file('attachment');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('expense/', $fileImageName);
            $imagePath = 'storage/expense/' . $fileImageName;
        }

        Expense::create([
            'purpose' => $request->purpose,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'date' => $request->date,
            'remark' => $request->remark,
            'attachment' => $imagePath,
        ]);

        return redirect()->route('expense.index')
            ->with('success', 'Expense added successfully');
    }

    public function edit(Expense $expense)
    {
        $banks = Bank::all();
        return view('admin.expense.edit', compact('expense', 'banks'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'purpose' => 'required',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|string',
            'date' => 'required|date',
            'attachment' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $expense->attachment;

        if ($request->hasFile('attachment')) {

            // ❌ remove old image
            if ($expense->attachment && file_exists(public_path($expense->attachment))) {
                unlink(public_path($expense->attachment));
            }

            // ✅ YOUR REQUIRED STORAGE STYLE
            $fileImage = $request->file('attachment');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('images/', $fileImageName);
            $imagePath = 'storage/images/' . $fileImageName;
        }

        $expense->update([
            'purpose' => $request->purpose,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'date' => $request->date,
            'remark' => $request->remark,
            'attachment' => $imagePath,
        ]);

        return redirect()->route('expense.index')
            ->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense deleted');
    }
}
