<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsController extends Controller
{
    private $savings = [];
    private $nextId = 1;

    public function __construct()
    {
        $this->savings = [
            [
                'id' => 1,
                'name' => 'Tabungan Rumah',
                'target_amount' => 100000000,
                'current_amount' => 25000000,
                'target_date' => '2025-12-31',
                'description' => 'Tabungan untuk DP rumah'
            ]
        ];
        $this->nextId = 2;
    }

    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pages.savings.index', ['savings' => $this->savings]);
    }

    public function create()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pages.savings.create');
    }

    public function store(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $saving = [
            'id' => $this->nextId++,
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount,
            'target_date' => $request->target_date,
            'description' => $request->description
        ];

        $this->savings[] = $saving;

        return redirect()->route('savings.index')->with('success', 'Target tabungan berhasil ditambahkan!');
    }
}