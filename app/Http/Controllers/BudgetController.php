<?php
// app/Http/Controllers/BudgetController.php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BudgetController extends Controller
{
    private function getCategories()
    {
        return [
            'makanan' => 'Makanan & Minuman',
            'transportasi' => 'Transportasi',
            'hiburan' => 'Hiburan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'belanja' => 'Belanja',
            'tagihan' => 'Tagihan & Utilitas',
            'investasi' => 'Investasi',
            'lainnya' => 'Lainnya'
        ];
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Ambil data dari database
        $budgets = Budget::orderBy('period', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $categories = $this->getCategories();

        // Hitung summary dengan cara yang benar
        $summary = [
            'total_budget' => $budgets->sum('allocated_amount'),
            'budget_count' => $budgets->count(),
            'category_count' => $budgets->pluck('category')->unique()->count(),
            'active_period_count' => $this->getActivePeriodCount($budgets)
        ];

        return view('pages.advance.budgets.index', compact('budgets', 'categories', 'summary'));
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $categories = $this->getCategories();

        return view('pages.advance.budgets.create', compact('categories'));
    }

    // Method untuk menghitung periode aktif
    private function getActivePeriodCount($budgets)
    {
        $currentDate = Carbon::now();
        $currentYearMonth = $currentDate->format('Y-m');

        return $budgets->filter(function($budget) use ($currentYearMonth) {
            return $budget->period >= $currentYearMonth;
        })->count();
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'budget_name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,transportasi,hiburan,kesehatan,pendidikan,belanja,tagihan,investasi,lainnya',
            'period' => 'required|date_format:Y-m',
            'allocated_amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            Budget::create([
                'budget_name' => $request->budget_name,
                'category' => $request->category,
                'period' => $request->period,
                'allocated_amount' => $request->allocated_amount,
                'description' => $request->description
            ]);

            return redirect()->route('advance.budgets.index')
                            ->with('success', 'Anggaran berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $budget = Budget::findOrFail($id);
        $categories = $this->getCategories();

        return view('advance.budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'budget_name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,transportasi,hiburan,kesehatan,pendidikan,belanja,tagihan,investasi,lainnya',
            'period' => 'required|date_format:Y-m',
            'allocated_amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            $budget = Budget::findOrFail($id);
            $budget->update([
                'budget_name' => $request->budget_name,
                'category' => $request->category,
                'period' => $request->period,
                'allocated_amount' => $request->allocated_amount,
                'description' => $request->description
            ]);

            return redirect()->route('advance.budgets.index')
                            ->with('success', 'Anggaran berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        try {
            $budget = Budget::findOrFail($id);
            $budget->delete();

            return redirect()->route('advance.budgets.index')
                            ->with('success', 'Anggaran berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method alternatif menggunakan scope active yang benar
    public function getActiveBudgets()
    {
        // Cara menggunakan scope yang benar
        $activeBudgets = Budget::active()->get();
        return $activeBudgets;
    }
}