<?php

namespace App\Http\Controllers;

use App\Models\StandardTransaction;   // ← MODEL YANG BENAR
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    private $defaultCategories = [
        'income' => [
            'Gaji',
            'Bonus',
            'Investasi',
            'Hadiah',
            'Lainnya'
        ],
        'expense' => [
            'Makanan & Minuman',
            'Transportasi',
            'Hiburan',
            'Kesehatan',
            'Pendidikan',
            'Belanja',
            'Tagihan',
            'Lainnya'
        ]
    ];

    public function index(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query dasar
        $query = StandardTransaction::where('user_id', $userId);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->where('date', '<=', $request->end_date);
        }

        // Order
        $transactions = $query->orderBy('date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->get();

        // Statistik
        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Categories list (unique)
        $categories = StandardTransaction::where('user_id', $userId)
                        ->select('category')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category');

        return view('pages.standard.transactions.index', [
            'transactions' => $transactions,
            'categories' => $this->defaultCategories,
            'filterCategories' => $categories,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netBalance' => $netBalance,
            'filters' => $request->all()
        ]);
    }

    public function create()
    {
        return view('pages.standard.transactions.create', [
            'categories' => $this->defaultCategories
        ]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'standard') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        StandardTransaction::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
            'user_id' => session('user_id'),
        ]);

        return redirect()
            ->route('standard.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $transaction = StandardTransaction::where('user_id', $userId)->find($id);

        if (!$transaction) {
            return redirect()->route('standard.transactions.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('pages.standard.transactions.edit', [
            'transaction' => $transaction,
            'categories' => $this->defaultCategories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $userId = session('user_id');

        $transaction = StandardTransaction::where('user_id', $userId)->find($id);

        if (!$transaction) {
            return redirect()->route('standard.transactions.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $transaction->update($validated);

            DB::commit();

            return redirect()->route('standard.transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.transactions.edit', $id)
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        $transaction = StandardTransaction::where('user_id', $userId)->find($id);

        if (!$transaction) {
            return redirect()->route('standard.transactions.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $transaction->delete();

            DB::commit();

            return redirect()->route('standard.transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.transactions.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
