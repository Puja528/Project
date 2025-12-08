<?php

namespace App\Http\Controllers;

use App\Models\FinancialNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialNoteController extends Controller
{
    private $categories = [
        'urgent_important' => [
            'name' => 'Mendesak & Penting',
            'color' => 'red',
            'description' => 'Tugas yang harus segera diselesaikan dan berdampak besar'
        ],
        'not_urgent_important' => [
            'name' => 'Tidak Mendesak & Penting',
            'color' => 'blue',
            'description' => 'Tugas penting yang bisa direncanakan untuk masa depan'
        ],
        'urgent_not_important' => [
            'name' => 'Mendesak & Tidak Penting',
            'color' => 'yellow',
            'description' => 'Tugas mendesak tapi dampaknya kecil'
        ],
        'not_urgent_not_important' => [
            'name' => 'Tidak Mendesak & Tidak Penting',
            'color' => 'green',
            'description' => 'Tugas yang bisa didelegasikan atau dihilangkan'
        ]
    ];

    public function index(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query dasar
        $query = FinancialNote::where('user_id', $userId);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('due_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->where('due_date', '<=', $request->end_date);
        }

        // Order dan get data
        $financialNotes = $query->orderBy('due_date', 'asc')
                              ->orderBy('priority', 'desc')
                              ->get();

        return view('pages.standard.financial-notes.index', [
            'financialNotes' => $financialNotes,
            'categories' => $this->categories,
            'filters' => $request->all()
        ]);
    }

    public function create()
    {
        return view('pages.standard.financial-notes.create', [
            'categories' => $this->categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:urgent_important,not_urgent_important,urgent_not_important,not_urgent_not_important',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        try {
            DB::beginTransaction();

            FinancialNote::create([
                'user_id' => $userId,
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'category' => $validated['category'],
                'due_date' => $validated['due_date'],
                'description' => $validated['description'],
                'priority' => $validated['priority'],
                'status' => $validated['status']
            ]);

            DB::commit();

            return redirect()->route('standard.financial-notes.index')
                ->with('success', 'Catatan keuangan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.financial-notes.create')
                ->with('error', 'Gagal menambahkan catatan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $financialNote = FinancialNote::where('user_id', $userId)->find($id);

        if (!$financialNote) {
            return redirect()->route('standard.financial-notes.index')
                ->with('error', 'Catatan keuangan tidak ditemukan.');
        }

        return view('pages.standard.financial-notes.edit', [
            'financialNote' => $financialNote,
            'categories' => $this->categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:urgent_important,not_urgent_important,urgent_not_important,not_urgent_not_important',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $financialNote = FinancialNote::where('user_id', $userId)->find($id);

        if (!$financialNote) {
            return redirect()->route('standard.financial-notes.index')
                ->with('error', 'Catatan keuangan tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $financialNote->update($validated);

            DB::commit();

            return redirect()->route('standard.financial-notes.index')
                ->with('success', 'Catatan keuangan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.financial-notes.edit', $id)
                ->with('error', 'Gagal memperbarui catatan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $financialNote = FinancialNote::where('user_id', $userId)->find($id);

        if (!$financialNote) {
            return redirect()->route('standard.financial-notes.index')
                ->with('error', 'Catatan keuangan tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $financialNote->delete();

            DB::commit();

            return redirect()->route('standard.financial-notes.index')
                ->with('success', 'Catatan keuangan berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.financial-notes.index')
                ->with('error', 'Gagal menghapus catatan: ' . $e->getMessage());
        }
    }
}
