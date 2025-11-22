<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactions = [];
    private $nextId = 1;

    public function __construct()
    {
        // Data dummy transaksi
        $this->transactions = [
            [
                'id' => 1,
                'title' => 'Belanja Bulanan',
                'amount' => 1200000,
                'type' => 'expense',
                'category' => 'belanja',
                'eisenhower_category' => 'urgent_important',
                'date' => '2024-01-15',
                'description' => 'Belanja kebutuhan bulanan keluarga'
            ],
            [
                'id' => 2,
                'title' => 'Gaji Bulanan',
                'amount' => 8500000,
                'type' => 'income', 
                'category' => 'gaji',
                'eisenhower_category' => 'not_urgent_important',
                'date' => '2024-01-01',
                'description' => 'Gaji bulan Januari'
            ]
        ];
        $this->nextId = 3;
    }

    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pages.transactions.index', [
            'transactions' => $this->transactions,
            'categories' => $this->getCategories()
        ]);
    }

    public function create()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pages.transactions.create', [
            'categories' => $this->getCategories(),
            'eisenhower_categories' => $this->getEisenhowerCategories()
        ]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'eisenhower_category' => 'required|in:urgent_important,not_urgent_important,urgent_not_important,not_urgent_not_important',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $transaction = [
            'id' => $this->nextId++,
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'eisenhower_category' => $request->eisenhower_category,
            'date' => $request->date,
            'description' => $request->description
        ];

        $this->transactions[] = $transaction;

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    private function getCategories()
    {
        return [
            'gaji' => 'Gaji',
            'investasi' => 'Investasi',
            'bonus' => 'Bonus',
            'belanja' => 'Belanja',
            'transportasi' => 'Transportasi',
            'hiburan' => 'Hiburan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'lainnya' => 'Lainnya'
        ];
    }

    private function getEisenhowerCategories()
    {
        return [
            'urgent_important' => 'Penting & Mendesak',
            'not_urgent_important' => 'Penting & Tidak Mendesak',
            'urgent_not_important' => 'Mendesak & Tidak Penting', 
            'not_urgent_not_important' => 'Tidak Mendesak & Tidak Penting'
        ];
    }
}