<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        // Sample data untuk advance reports
        $reportData = [
            'monthly_summary' => [
                'total_income' => 25000000,
                'total_expense' => 18000000,
                'net_income' => 7000000,
                'savings_rate' => 28.0
            ],
            'top_categories' => [
                ['name' => 'Gaji', 'amount' => 15000000, 'percentage' => 60],
                ['name' => 'Investasi', 'amount' => 5000000, 'percentage' => 20],
                ['name' => 'Bonus', 'amount' => 5000000, 'percentage' => 20],
            ],
            'expense_categories' => [
                ['name' => 'Hiburan', 'amount' => 5000000, 'percentage' => 27.8],
                ['name' => 'Makanan', 'amount' => 4500000, 'percentage' => 25],
                ['name' => 'Transportasi', 'amount' => 4000000, 'percentage' => 22.2],
                ['name' => 'Tagihan', 'amount' => 3000000, 'percentage' => 16.7],
                ['name' => 'Lainnya', 'amount' => 1500000, 'percentage' => 8.3],
            ]
        ];

        return view('pages.advance.reports.index', compact('reportData'));
    }

    public function exportBasic(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'export_type' => 'required|in:transactions,savings,financial_notes'
        ]);

        // Sample data - dalam implementasi real, query dari database
        $data = $this->generateSampleData($validated);

        // Return response dengan data (dalam implementasi real, generate file)
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diekspor',
            'data' => $data,
            'export_type' => $validated['export_type'],
            'period' => $validated['start_date'] . ' to ' . $validated['end_date']
        ]);
    }

    public function exportAdvance(Request $request)
    {
        // Untuk advance user - implementasi lebih kompleks
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:financial_statement,cash_flow,tax_report'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan advance berhasil diekspor',
            'report_type' => $validated['report_type'],
            'period' => $validated['start_date'] . ' to ' . $validated['end_date']
        ]);
    }

    public function cashFlow()
    {
        // Sample cash flow data untuk advance user
        $cashFlowData = [
            'operating_activities' => 15000000,
            'investing_activities' => -5000000,
            'financing_activities' => 2000000,
            'net_cash_flow' => 12000000
        ];

        return view('pages.advance.reports.cash-flow', compact('cashFlowData'));
    }

    public function taxPlanning()
    {
        // Sample tax planning data untuk advance user
        $taxData = [
            'taxable_income' => 120000000,
            'tax_deductions' => 15000000,
            'tax_paid' => 9000000,
            'tax_remaining' => 6000000
        ];

        return view('pages.advance.reports.tax-planning', compact('taxData'));
    }

    private function generateSampleData($params)
    {
        // Generate sample data berdasarkan tipe export
        switch ($params['export_type']) {
            case 'transactions':
                return [
                    ['Date' => '2024-01-05', 'Description' => 'Gaji Bulanan', 'Amount' => 8500000, 'Type' => 'Income', 'Category' => 'Gaji'],
                    ['Date' => '2024-01-07', 'Description' => 'Bayar Listrik', 'Amount' => 450000, 'Type' => 'Expense', 'Category' => 'Tagihan'],
                    ['Date' => '2024-01-08', 'Description' => 'Belanja Bulanan', 'Amount' => 1200000, 'Type' => 'Expense', 'Category' => 'Belanja'],
                ];

            case 'savings':
                return [
                    ['Name' => 'Dana Darurat', 'Target' => 10000000, 'Current' => 3250000, 'Progress' => '32.5%', 'Target Date' => '2024-12-31'],
                    ['Name' => 'Liburan', 'Target' => 5000000, 'Current' => 1500000, 'Progress' => '30%', 'Target Date' => '2024-06-30'],
                ];

            case 'financial_notes':
                return [
                    ['Title' => 'Bayar Listrik', 'Amount' => 450000, 'Category' => 'Mendesak & Penting', 'Due Date' => '2024-01-15', 'Priority' => 'Tinggi'],
                    ['Title' => 'Investasi Saham', 'Amount' => 2000000, 'Category' => 'Tidak Mendesak & Penting', 'Due Date' => '2024-01-30', 'Priority' => 'Sedang'],
                ];

            default:
                return [];
        }
    }
}