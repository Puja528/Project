<?php
// app/Http/Controllers/BudgetController.php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budgets = Budget::latest()->get();

        return view('pages.budgets.index', [
            'budgets' => $budgets,
            'categories' => Budget::getCategories()
        ]);
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.budgets.create', [
            'categories' => Budget::getCategories()
        ]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'category' => 'required|string',
            'month_year' => 'required|date_format:Y-m',
            'allocated_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Budget::create([
            'category' => $validated['category'],
            'month_year' => $validated['month_year'],
            'allocated_amount' => $validated['allocated_amount'],
            'used_amount' => 0,
            'description' => $validated['description']
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budget = Budget::findOrFail($id);

        return view('pages.budgets.show', compact('budget'));
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budget = Budget::findOrFail($id);

        return view('pages.budgets.edit', [
            'budget' => $budget,
            'categories' => Budget::getCategories()
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budget = Budget::findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|string',
            'month_year' => 'required|date_format:Y-m',
            'allocated_amount' => 'required|numeric|min:0',
            'used_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budget = Budget::findOrFail($id);
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil dihapus!');
    }
}
