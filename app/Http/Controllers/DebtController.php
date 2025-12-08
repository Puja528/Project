<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter per_page dari request (default 10)
        $perPage = $request->get('per_page', 10);

        // Query dengan sorting
        $query = Debt::query()
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'desc');

        // Jika ada auth, filter berdasarkan user
        // if (auth()->check()) {
        //     $query->where('user_id', auth()->id());
        // }

        // Pagination
        $debts = $query->paginate($perPage);

        // Hitung summary
        $totalPiutang = Debt::where('type', 'piutang')->sum('amount');
        $totalHutang = Debt::where('type', 'hutang')->sum('amount');
        $netPosition = $totalPiutang - $totalHutang;

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

        // Hitung jumlah dengan bunga jika ada
        $amount = $validated['amount'];
        if ($validated['interest_rate'] > 0) {
            $amount = $validated['amount'] + ($validated['amount'] * $validated['interest_rate'] / 100);
        }

        Debt::create([
            'type' => $validated['type'],
            'person_name' => $validated['person_name'],
            'amount' => $amount,
            'initial_amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'interest_rate' => $validated['interest_rate'] ?? 0,
            'status' => $validated['status'],
            'description' => $validated['description'],
            // Jika ada auth, tambahkan user_id
            // 'user_id' => auth()->id(),
        ]);

        return redirect()->route('advance.debts.index')
            ->with('success', 'Data hutang/piutang berhasil ditambahkan!');
    }

    public function edit(Debt $debt)
    {
        // Jika ada auth, tambahkan authorization
        // $this->authorize('update', $debt);

        return view('pages.advance.debts.edit', compact('debt'));
    }

    public function update(Request $request, Debt $debt)
    {
        // Jika ada auth, tambahkan authorization
        // $this->authorize('update', $debt);

        $validated = $request->validate([
            'type' => 'required|in:piutang,hutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,paid,overdue',
            'description' => 'nullable|string|max:500',
        ]);

        // Hitung jumlah dengan bunga jika ada
        $amount = $validated['amount'];
        if ($validated['interest_rate'] > 0) {
            $amount = $validated['amount'] + ($validated['amount'] * $validated['interest_rate'] / 100);
        }

        $debt->update([
            'type' => $validated['type'],
            'person_name' => $validated['person_name'],
            'amount' => $amount,
            'initial_amount' => $validated['amount'],
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
        try {
            // Debug: cek apakah data ditemukan
            if (!$debt) {
                return redirect()->route('advance.debts.index')
                    ->with('error', 'Data tidak ditemukan!');
            }

            // Simpan nama untuk flash message
            $personName = $debt->person_name;

            // Hapus data
            $debt->delete();

            return redirect()->route('advance.debts.index')
                ->with('success', 'Data "' . $personName . '" berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('advance.debts.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
