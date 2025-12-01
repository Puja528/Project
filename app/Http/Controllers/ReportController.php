<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportBasic()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Simulasi export data dasar
        return response()->json([
            'message' => 'Data berhasil diekspor',
            'data' => [
                'transactions' => [],
                'savings' => [],
                'period' => date('Y-m')
            ]
        ]);
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $reports = [
            [
                'id' => 1,
                'period' => 'Januari 2024',
                'total_income' => 18500000,
                'total_expense' => 13250000,
                'net_income' => 5250000,
                'savings_rate' => 28.4
            ]
        ];

        return view('pages.advance.reports.index', compact('reports'));
    }

    public function cashFlow()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $cashFlowData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'income' => [18500, 19200, 17800, 21000, 19500, 22000],
            'expense' => [13250, 14500, 12800, 15600, 14200, 16800],
            'net' => [5250, 4700, 5000, 5400, 5300, 5200]
        ];

        return view('pages.advance.reports.cashflow', compact('cashFlowData'));
    }

    public function taxPlanning()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $taxData = [
            'annual_income' => 222000000,
            'taxable_income' => 192000000,
            'tax_owed' => 37500000,
            'tax_paid' => 30000000,
            'tax_deductions' => 30000000
        ];

        return view('pages.advance.reports.tax', compact('taxData'));
    }

    public function exportAdvance()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return response()->json([
            'message' => 'Laporan profesional berhasil diekspor',
            'data' => [
                'financial_statements' => [],
                'cash_flow' => [],
                'investment_portfolio' => [],
                'tax_summary' => []
            ]
        ]);
    }

}
