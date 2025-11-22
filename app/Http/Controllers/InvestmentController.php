<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    private $investments = [];
    private $nextId = 1;

    public function __construct()
    {
        $this->investments = [
            [
                'id' => 1,
                'name' => 'Saham BBCA',
                'type' => 'saham',
                'initial_amount' => 10000000,
                'current_value' => 12500000,
                'return_percentage' => 25.0,
                'start_date' => '2023-01-15',
                'risk_level' => 'medium'
            ]
        ];
        $this->nextId = 2;
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.investments.index', ['investments' => $this->investments]);
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.investments.create', ['types' => $this->getInvestmentTypes()]);
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'risk_level' => 'required|in:low,medium,high'
        ]);

        $return_percentage = (($request->current_value - $request->initial_amount) / $request->initial_amount) * 100;

        $investment = [
            'id' => $this->nextId++,
            'name' => $request->name,
            'type' => $request->type,
            'initial_amount' => $request->initial_amount,
            'current_value' => $request->current_value,
            'return_percentage' => round($return_percentage, 2),
            'start_date' => $request->start_date,
            'risk_level' => $request->risk_level
        ];

        $this->investments[] = $investment;

        return redirect()->route('investments.index')->with('success', 'Investasi berhasil ditambahkan!');
    }

    private function getInvestmentTypes()
    {
        return [
            'saham' => 'Saham',
            'reksadana' => 'Reksadana',
            'deposito' => 'Deposito',
            'obligasi' => 'Obligasi',
            'emas' => 'Emas',
            'property' => 'Property',
            'lainnya' => 'Lainnya'
        ];
    }
}