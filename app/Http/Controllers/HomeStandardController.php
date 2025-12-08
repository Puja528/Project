<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\FinancialNote;
use App\Models\Saving;

class HomeStandardController extends Controller
{
    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session('user_id');

        // Get real data from database
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Monthly transactions
        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $totalBalance = $monthlyIncome - $monthlyExpense;

        // Total savings
        $totalSavings = Saving::where('user_id', $userId)->sum('current_amount');

        // Recent transactions
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Financial notes for Eisenhower matrix
        $eisenhowerData = FinancialNote::where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('due_date', 'asc')
            ->limit(6)
            ->get();

        // Savings goals with progress
        $savingsGoals = Saving::where('user_id', $userId)
            ->orderBy('target_date', 'asc')
            ->limit(3)
            ->get()
            ->map(function ($saving) {
                return [
                    'name' => $saving->name,
                    'target' => $saving->target_amount,
                    'current' => $saving->current_amount,
                    'progress' => $saving->progress_percentage
                ];
            });

        // Monthly chart data (last 6 months)
        $monthlyData = $this->getMonthlyChartData($userId);

        $data = [
            'username'        => session('username'),
            'total_balance'   => $totalBalance,
            'monthly_income'  => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'savings'         => $totalSavings,
            'monthly_data'    => $monthlyData,
            'eisenhower_data' => $eisenhowerData,
            'recent_transactions' => $recentTransactions,
            'savings_goals'   => $savingsGoals,
        ];

        return view('pages.home.standard', $data);
    }

    private function getMonthlyChartData($userId)
    {
        $months = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $month = $date->month;
            $year = $date->year;

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');

            $months[] = $monthYear;
            $incomeData[] = $income / 1000; // Convert to thousands for better chart display
            $expenseData[] = $expense / 1000;
        }

        return [
            'labels'  => $months,
            'income'  => $incomeData,
            'expense' => $expenseData,
        ];
    }
}
