<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    private $budgets = [];
    private $nextId = 1;

    public function __construct()
    {
        $this->budgets = [
            [
                'id' => 1,
                'category' => 'Operasional',
                'month_year' => '2024-01',
                'allocated_amount' => 5000000,
                'used_amount' => 4200000,
                'description' => 'Budget operasional bulanan'
            ]
        ];
        $this->nextId = 2;
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.budgets.index', ['budgets' => $this->budgets]);
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.budgets.create', ['categories' => $this->getCategories()]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'category' => 'required|string',
            'month_year' => 'required|string',
            'allocated_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $budget = [
            'id' => $this->nextId++,
            'category' => $request->category,
            'month_year' => $request->month_year,
            'allocated_amount' => $request->allocated_amount,
            'used_amount' => 0,
            'description' => $request->description
        ];

        $this->budgets[] = $budget;

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil ditambahkan!');
    }

    private function getCategories()
    {
        return [
            'operasional' => 'Operasional',
            'pemasaran' => 'Pemasaran',
            'gaji' => 'Gaji Karyawan',
            'investasi' => 'Investasi',
            'pajak' => 'Pajak',
            'lainnya' => 'Lainnya'
        ];
    }
}