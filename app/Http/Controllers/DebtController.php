<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    private $debts = [];
    private $nextId = 1;

    public function __construct()
    {
        $this->debts = [
            [
                'id' => 1,
                'type' => 'piutang',
                'person_name' => 'PT. ABC Supplier',
                'amount' => 5000000,
                'initial_amount' => 5000000,
                'due_date' => '2024-02-15',
                'status' => 'active',
                'interest_rate' => 0,
                'description' => ''
            ]
        ];
        $this->nextId = 2;
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Gunakan $this->debts untuk perhitungan
        $totalPiutang = array_sum(array_column(array_filter($this->debts, function($debt) { 
            return $debt['type'] === 'piutang'; 
        }), 'amount'));

        $totalHutang = array_sum(array_column(array_filter($this->debts, function($debt) { 
            return $debt['type'] === 'hutang'; 
        }), 'amount'));

        $netPosition = $totalPiutang - $totalHutang;

        // Kirim data ke view dengan array asosiatif
        return view('pages.debts.index', [
            'debts' => $this->debts,
            'totalPiutang' => $totalPiutang,
            'totalHutang' => $totalHutang,
            'netPosition' => $netPosition
        ]);
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

        $request->validate([
            'type' => 'required|in:hutang,piutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $debt = [
            'id' => $this->nextId++,
            'type' => $request->type,
            'person_name' => $request->person_name,
            'amount' => $request->amount,
            'initial_amount' => $request->amount,
            'due_date' => $request->due_date,
            'interest_rate' => $request->interest_rate ?? 0,
            'description' => $request->description,
            'status' => 'active'
        ];

        $this->debts[] = $debt;

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil ditambahkan!');
    }

    // Method edit, update, dan destroy
    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $debt = collect($this->debts)->firstWhere('id', $id);
        
        if (!$debt) {
            return redirect()->route('debts.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages.debts.edit', compact('debt'));
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'type' => 'required|in:hutang,piutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,paid,overdue'
        ]);

        foreach ($this->debts as &$debt) {
            if ($debt['id'] == $id) {
                $debt['type'] = $request->type;
                $debt['person_name'] = $request->person_name;
                $debt['amount'] = $request->amount;
                $debt['due_date'] = $request->due_date;
                $debt['interest_rate'] = $request->interest_rate ?? 0;
                $debt['description'] = $request->description;
                $debt['status'] = $request->status;
                break;
            }
        }

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $this->debts = array_filter($this->debts, function($debt) use ($id) {
            return $debt['id'] != $id;
        });

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil dihapus!');
    }
}