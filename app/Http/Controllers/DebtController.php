<?php
// app/Http/Controllers/DebtController.php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debts = Debt::latest()->get();

        return view('pages.debts.index', compact('debts'));
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.debts.create');
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'type' => 'required|in:hutang,piutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Debt::create([
            'type' => $validated['type'],
            'person_name' => $validated['person_name'],
            'amount' => $validated['amount'],
            'initial_amount' => $validated['amount'],
            'paid_amount' => 0,
            'due_date' => $validated['due_date'],
            'interest_rate' => $validated['interest_rate'] ?? 0,
            'description' => $validated['description'],
            'status' => 'active'
        ]);

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);

        return view('pages.debts.show', compact('debt'));
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);

        return view('pages.debts.edit', compact('debt'));
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:hutang,piutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,paid,overdue'
        ]);

        $debt->update($validated);

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);
        $debt->delete();

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil dihapus!');
    }

    // Method untuk menambah pembayaran
    public function addPayment(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);

        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0'
        ]);

        $debt->addPayment($validated['payment_amount']);

        return redirect()->route('debts.show', $debt->id)->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    // Method untuk menandai sebagai lunas
    public function markAsPaid($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = Debt::findOrFail($id);
        $debt->markAsPaid();

        return redirect()->route('debts.show', $debt->id)->with('success', 'Status berhasil diubah menjadi lunas!');
    }
}
