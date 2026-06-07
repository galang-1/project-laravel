<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $budgets = $user->budgets()->with('category')->get();
        $categories = $user->categories()->where('type', 'expense')->get();

        // Cek pengeluaran vs budget per kategori
        $warnings = [];
        foreach ($budgets as $budget) {
            $spent = $user->transactions()
                ->where('category_id', $budget->category_id)
                ->where('type', 'expense')
                ->whereMonth('date', now()->month)
                ->sum('amount');

            $percentage = $budget->limit_amount > 0
                ? ($spent / $budget->limit_amount) * 100
                : 0;

            $warnings[] = [
                'category' => $budget->category->name,
                'limit'    => $budget->limit_amount,
                'spent'    => $spent,
                'percent'  => round($percentage),
                'over'     => $spent > $budget->limit_amount,
            ];
        }

        return view('budgets.index', compact('budgets', 'categories', 'warnings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'limit_amount' => 'required|numeric|min:1',
        ]);

        // Update kalau sudah ada, buat baru kalau belum
        Budget::updateOrCreate(
            ['user_id' => auth()->id(), 'category_id' => $request->category_id],
            ['limit_amount' => $request->limit_amount]
        );

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil disimpan!');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget berhasil dihapus!');
    }
}