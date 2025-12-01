<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::orderBy('due_date', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        // Hitung summary
        $totalPiutang = Debt::where('type', 'piutang')->sum('amount');
        $totalHutang = Debt::where('type', 'hutang')->sum('amount');
        $netPosition = $totalPiutang - $totalHutang;

        // Tambahkan flag is_overdue untuk setiap debt
        $debts->getCollection()->transform(function ($debt) {
            $debt->is_overdue = $debt->status === 'active' && Carbon::parse($debt->due_date)->isPast();
            return $debt;
        });

        return view('pages.advance.debts.index', compact('debts', 'totalPiutang', 'totalHutang', 'netPosition'));
    }

    public function create()
    {
        return view('pages.advance.debts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:piutang,hutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,paid,overdue',
            'description' => 'nullable|string|max:500',
        ]);

        Debt::create([
            'type' => $validated['type'],
            'person_name' => $validated['person_name'],
            'amount' => $validated['amount'],
            'initial_amount' => $validated['amount'], // Sama dengan amount untuk awal
            'due_date' => $validated['due_date'],
            'interest_rate' => $validated['interest_rate'] ?? 0,
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('advance.debts.index')
                        ->with('success', 'Data hutang/piutang berhasil ditambahkan!');
    }

    public function edit(Debt $debt)
    {
        return view('advance.debts.edit', compact('debt'));
    }

    public function update(Request $request, Debt $debt)
    {
        $validated = $request->validate([
            'type' => 'required|in:piutang,hutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,paid,overdue',
            'description' => 'nullable|string|max:500',
        ]);

        $debt->update([
            'type' => $validated['type'],
            'person_name' => $validated['person_name'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'interest_rate' => $validated['interest_rate'] ?? 0,
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('advance.debts.index')
                        ->with('success', 'Data hutang/piutang berhasil diperbarui!');
    }

    public function destroy(Debt $debt)
    {
        $debt->delete();

        return redirect()->route('advance.debts.index')
                        ->with('success', 'Data hutang/piutang berhasil dihapus!');
    }
}
