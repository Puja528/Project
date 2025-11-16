<?php
// app/Http/Controllers/InvestmentController.php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investments = Investment::latest()->get();

        return view('pages.investments.index', [
            'investments' => $investments,
            'types' => Investment::getInvestmentTypes(),
            'riskLevels' => Investment::getRiskLevels()
        ]);
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.investments.create', [
            'types' => Investment::getInvestmentTypes(),
            'riskLevels' => Investment::getRiskLevels()
        ]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'risk_level' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'symbol' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'average_price' => 'nullable|numeric|min:0'
        ]);

        // Calculate return
        $return_amount = $validated['current_value'] - $validated['initial_amount'];
        $return_percentage = $validated['initial_amount'] > 0 ? ($return_amount / $validated['initial_amount']) * 100 : 0;

        Investment::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'initial_amount' => $validated['initial_amount'],
            'current_value' => $validated['current_value'],
            'return_amount' => $return_amount,
            'return_percentage' => round($return_percentage, 2),
            'start_date' => $validated['start_date'],
            'risk_level' => $validated['risk_level'],
            'description' => $validated['description'],
            'symbol' => $validated['symbol'],
            'quantity' => $validated['quantity'],
            'average_price' => $validated['average_price'],
            'status' => 'active'
        ]);

        return redirect()->route('investments.index')->with('success', 'Investasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);

        return view('pages.investments.show', compact('investment'));
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);

        return view('pages.investments.edit', [
            'investment' => $investment,
            'types' => Investment::getInvestmentTypes(),
            'riskLevels' => Investment::getRiskLevels(),
            'statuses' => Investment::getStatuses()
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'risk_level' => 'required|in:low,medium,high',
            'status' => 'required|in:active,sold,matured',
            'description' => 'nullable|string',
            'symbol' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'average_price' => 'nullable|numeric|min:0'
        ]);

        // Calculate return
        $return_amount = $validated['current_value'] - $validated['initial_amount'];
        $return_percentage = $validated['initial_amount'] > 0 ? ($return_amount / $validated['initial_amount']) * 100 : 0;

        $validated['return_amount'] = $return_amount;
        $validated['return_percentage'] = round($return_percentage, 2);

        $investment->update($validated);

        return redirect()->route('investments.index')->with('success', 'Investasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);
        $investment->delete();

        return redirect()->route('investments.index')->with('success', 'Investasi berhasil dihapus!');
    }

    // Method untuk update current value
    public function updateValue(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);

        $validated = $request->validate([
            'current_value' => 'required|numeric|min:0'
        ]);

        $investment->update([
            'current_value' => $validated['current_value']
        ]);

        // Recalculate return
        $investment->calculateReturn();
        $investment->save();

        return redirect()->route('investments.show', $investment->id)->with('success', 'Nilai investasi berhasil diperbarui!');
    }

    // Method untuk mark as sold
    public function markAsSold(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::findOrFail($id);

        $validated = $request->validate([
            'sell_value' => 'required|numeric|min:0',
            'sell_date' => 'required|date'
        ]);

        $investment->update([
            'current_value' => $validated['sell_value'],
            'status' => 'sold'
        ]);

        // Recalculate return
        $investment->calculateReturn();
        $investment->save();

        return redirect()->route('investments.show', $investment->id)->with('success', 'Investasi berhasil ditandai sebagai terjual!');
    }
}
