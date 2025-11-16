<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transactions = Transaction::latest()->get();

        return view('pages.transactions.index', [
            'transactions' => $transactions,
            'categories' => Transaction::getCategories()
        ]);
    }

    public function create()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pages.transactions.create', [
            'categories' => Transaction::getCategories()
            // Hapus eisenhower_categories karena sudah tidak digunakan
        ]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'user' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'date' => 'required|date'
        ]);

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::findOrFail($id);
        return view('pages.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::findOrFail($id);

        return view('pages.transactions.edit', [
            'transaction' => $transaction,
            'categories' => Transaction::getCategories()
            // Hapus eisenhower_categories karena sudah tidak digunakan
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'user' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'date' => 'required|date'
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
