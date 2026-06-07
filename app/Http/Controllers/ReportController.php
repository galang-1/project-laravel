<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $year = $request->year ?? date('Y');

        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $income = $user->transactions()
                ->where('type', 'income')
                ->whereYear('date', $year)
                ->whereMonth('date', $m)
                ->sum('amount');

            $expense = $user->transactions()
                ->where('type', 'expense')
                ->whereYear('date', $year)
                ->whereMonth('date', $m)
                ->sum('amount');

            $monthlyData[] = [
                'month'   => $m,
                'label'   => date('M', mktime(0, 0, 0, $m, 1)),
                'income'  => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
            ];
        }

        $topCategories = $user->transactions()
            ->where('type', 'expense')
            ->whereYear('date', $year)
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(fn($items, $name) => [
                'name'  => $name,
                'total' => $items->sum('amount'),
            ])
            ->sortByDesc('total')
            ->take(5)
            ->values();

        $totalIncome  = collect($monthlyData)->sum('income');
        $totalExpense = collect($monthlyData)->sum('expense');
        $totalBalance = $totalIncome - $totalExpense;
        $years = range(date('Y'), date('Y') - 3);

        return view('reports.index', compact(
            'monthlyData', 'topCategories',
            'totalIncome', 'totalExpense', 'totalBalance',
            'year', 'years'
        ));
    }
}