<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $query = auth()->user()->transactions()->with('category');

    if ($request->month) {
        $query->whereMonth('date', $request->month);
    }

    if ($request->year) {
        $query->whereYear('date', $request->year);
    }

    $transactions = $query->latest()->paginate(10);

    $totalIncome  = auth()->user()->transactions()
        ->when($request->month, fn($q) => $q->whereMonth('date', $request->month))
        ->when($request->year,  fn($q) => $q->whereYear('date',  $request->year))
        ->where('type', 'income')->sum('amount');

    $totalExpense = auth()->user()->transactions()
        ->when($request->month, fn($q) => $q->whereMonth('date', $request->month))
        ->when($request->year,  fn($q) => $q->whereYear('date',  $request->year))
        ->where('type', 'expense')->sum('amount');

    return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense'));
}

    public function create()
    {
        $categories = auth()->user()->categories()->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date',
            'note'        => 'nullable|string|max:255',
        ]);

        auth()->user()->transactions()->create($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaction)
{
    $categories = auth()->user()->categories()->get();
    return view('transactions.edit', compact('transaction', 'categories'));
}

public function update(Request $request, Transaction $transaction)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'type'        => 'required|in:income,expense',
        'amount'      => 'required|numeric|min:1',
        'date'        => 'required|date',
        'note'        => 'nullable|string|max:255',
    ]);

    $transaction->update($request->all());
    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
}

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}