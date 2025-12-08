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

        // 1. Total Balance
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
            ->sum('amount');

        $totalBalance = $totalIncome - $totalExpense;

        // Hitung saldo bulan lalu untuk persentase
        $lastMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->whereMonth('date', $lastMonth)
            ->whereYear('date', $lastMonthYear)
            ->sum('amount');

        $lastMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
            ->whereMonth('date', $lastMonth)
            ->whereYear('date', $lastMonthYear)
            ->sum('amount');

        $lastMonthBalance = $lastMonthIncome - $lastMonthExpense;

        // 2. Pemasukan Bulan Ini
        $currentMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $lastMonthIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->whereMonth('date', $lastMonth)
            ->whereYear('date', $lastMonthYear)
            ->sum('amount');

        // 3. Pengeluaran Bulan Ini
        $currentMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $lastMonthExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
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
        $investment = Investment::where('user_id', $user->id)
            ->whereIn('type', ['saham', 'reksadana', 'deposito', 'obligasi', 'emas', 'property', 'lainnya']) // pastikan jenis yang dipakai tepat
            ->get();

        // Hitung return percentage langsung
        $investment->each(function ($investment) {
            if ($investment->initial_amount > 0) {
                $investment->return_percentage =
                    (($investment->current_value - $investment->initial_amount) / $investment->initial_amount) * 100;
            } else {
                $investment->return_percentage = 0;
            }
        });

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
            'investments' => $investment,
            'monthlyLabels' => $monthlyData['labels'],
            'monthlyIncome' => $monthlyData['pemasukan'],
            'monthlyExpense' => $monthlyData['pengeluaran'],
        ]);
    }

    private function getMonthlyData($userId)
    {
        $data = [
            'labels' => [],
            'pemasukan' => [],
            'pengeluaran' => []
        ];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $pemasukan = Transaction::where('user_id', $userId)
                ->where('type', 'pemasukan')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $pengeluaran = Transaction::where('user_id', $userId)
                ->where('type', 'pengeluaran')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $data['labels'][] = $date->format('M');
            $data['pemasukan'][] = $pemasukan / 1000000; // Konversi ke juta untuk grafik
            $data['pengeluaran'][] = $pengeluaran / 1000000;
        }

        return $data;
    }
}