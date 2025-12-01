<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::all();
        return view('pages.advance.investments.index', compact('investments'));
    }

    public function create()
    {
        $types = [
            'saham', 'reksadana', 'deposito', 'obligasi', 'emas', 'property', 'lainnya'
        ];

        return view('pages.advance.investments.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'risk_level' => 'required|in:low,medium,high',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date'
        ]);

        Investment::create($request->all());

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $investment = Investment::findOrFail($id);

        $types = [
            'saham', 'reksadana', 'deposito', 'obligasi', 'emas', 'property', 'lainnya'
        ];

        return view('advance.investments.edit', compact('investment', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'risk_level' => 'required|in:low,medium,high',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date'
        ]);

        $investment = Investment::findOrFail($id);
        $investment->update($request->all());

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Investment::findOrFail($id)->delete();

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil dihapus!');
    }
}