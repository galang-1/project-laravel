<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $recentTransactions = $user->transactions()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $expenseByCategory = $user->transactions()
            ->where('type', 'expense')
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(fn($items, $name) => (object)[
                'name' => $name,
                'total' => $items->sum('amount')
            ])
            ->values();

        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'balance',
            'recentTransactions', 'expenseByCategory'
        ));
    }
}