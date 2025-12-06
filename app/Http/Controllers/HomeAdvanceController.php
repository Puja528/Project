<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Investment;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeAdvanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastMonthYear = Carbon::now()->subMonth()->year;

        // 1. Total Balance (dari saldo user atau akumulasi transaksi)
        $totalBalance = $user->balance ?? 0;

        // Hitung saldo bulan lalu untuk persentase
        $lastMonthBalance = $user->last_month_balance ?? ($totalBalance * 100 / 108.5); // Contoh perhitungan

        // 2. Pemasukan Bulan Ini
        $currentMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $lastMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('date', $lastMonth)
            ->whereYear('date', $lastMonthYear)
            ->sum('amount');

        // 3. Pengeluaran Bulan Ini
        $currentMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $lastMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('date', $lastMonth)
            ->whereYear('date', $lastMonthYear)
            ->sum('amount');

        // 4. Net Profit (Pemasukan - Pengeluaran)
        $currentMonthProfit = $currentMonthIncome - $currentMonthExpense;
        $lastMonthProfit = $lastMonthIncome - $lastMonthExpense;

        // 5. Hitung Persentase Perubahan
        $balancePercentage = $lastMonthBalance > 0
            ? (($totalBalance - $lastMonthBalance) / $lastMonthBalance * 100)
            : 0;

        $incomePercentage = $lastMonthIncome > 0
            ? (($currentMonthIncome - $lastMonthIncome) / $lastMonthIncome * 100)
            : 0;

        $expensePercentage = $lastMonthExpense > 0
            ? (($currentMonthExpense - $lastMonthExpense) / $lastMonthExpense * 100)
            : 0;

        $profitPercentage = $lastMonthProfit > 0
            ? (($currentMonthProfit - $lastMonthProfit) / $lastMonthProfit * 100)
            : 0;

        // 6. Portfolio Investasi
        $investments = Investment::where('user_id', $user->id)->get();

        // Hitung return percentage untuk setiap investment
        $investments->each(function ($investment) {
            if ($investment->initial_amount > 0) {
                $investment->return_percentage =
                    (($investment->current_value - $investment->initial_amount) / $investment->initial_amount) * 100;
            } else {
                $investment->return_percentage = 0;
            }
        });

        // Tampilkan hanya saham dan reksadana misalnya
        $investments = Investment::where('user_id', $user->id)
            ->whereIn('type', ['saham', 'reksadana', 'obligasi'])
            ->get();

        // 7. Data Grafik 12 Bulan Terakhir
        $monthlyData = $this->getMonthlyData($user->id);

        return view('pages.home.advance', [
            'totalBalance' => $totalBalance,
            'balancePercentage' => $balancePercentage,
            'currentMonthIncome' => $currentMonthIncome,
            'incomePercentage' => $incomePercentage,
            'currentMonthExpense' => $currentMonthExpense,
            'expensePercentage' => $expensePercentage,
            'currentMonthProfit' => $currentMonthProfit,
            'profitPercentage' => $profitPercentage,
            'investments' => $investments,
            'monthlyLabels' => $monthlyData['labels'],
            'monthlyIncome' => $monthlyData['income'],
            'monthlyExpense' => $monthlyData['expense'],
        ]);
    }

    private function getMonthlyData($userId)
    {
        $data = [
            'labels' => [],
            'income' => [],
            'expense' => []
        ];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $data['labels'][] = $date->format('M');
            $data['income'][] = $income / 1000000; // Konversi ke juta untuk grafik
            $data['expense'][] = $expense / 1000000;
        }

        return $data;
    }
}
