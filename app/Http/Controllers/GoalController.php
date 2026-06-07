<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = auth()->user()->goals()->latest()->get();
        return view('goals.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'icon'          => 'nullable|string|max:10',
            'target_amount' => 'required|numeric|min:1',
            'deadline'      => 'nullable|date',
        ]);

        auth()->user()->goals()->create($request->all());
        return redirect()->route('goals.index')->with('success', 'Goal berhasil ditambahkan!');
    }

    public function addSaving(Request $request, Goal $goal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $goal->increment('saved_amount', $request->amount);
        return redirect()->route('goals.index')->with('success', 'Tabungan berhasil ditambahkan!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal berhasil dihapus!');
    }
}