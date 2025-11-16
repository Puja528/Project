<?php

namespace App\Http\Controllers;

class HomeAdvanceController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Data untuk advance user (bisnis)
        $data = [
            'username'        => session('username'),
            'total_balance'   => 25500000,
            'monthly_income'  => 18500000,
            'monthly_expense' => 13250000,
            'savings'         => 8250000,
            'monthly_data'    => [
                'labels'  => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'income'  => [18500, 19200, 17800, 21000, 19500, 22000, 23500, 22800, 24200, 25800, 24500, 26500],
                'expense' => [13250, 14500, 12800, 15600, 14200, 16800, 15800, 17200, 16500, 18200, 17500, 19200],
            ],
            'eisenhower_data' => [
                ['task' => 'Bayar Gaji Karyawan', 'amount' => 8500000, 'category' => 'urgent_important', 'due_date' => '2024-01-25'],
                ['task' => 'Pajak Bulanan', 'amount' => 3750000, 'category' => 'urgent_important', 'due_date' => '2024-01-30'],
                ['task' => 'Investasi Peralatan', 'amount' => 15000000, 'category' => 'not_urgent_important', 'due_date' => '2024-03-28'],
                ['task' => 'Dana Ekspansi', 'amount' => 50000000, 'category' => 'not_urgent_important', 'due_date' => '2024-06-30'],
                ['task' => 'Team Building', 'amount' => 3500000, 'category' => 'urgent_not_important', 'due_date' => '2024-01-20'],
                ['task' => 'Renovasi Kantor', 'amount' => 25000000, 'category' => 'not_urgent_not_important', 'due_date' => '2024-12-31'],
            ],
            'investment_data' => [
                ['name' => 'Saham BBCA', 'amount' => 12500000, 'return' => 25.0],
                ['name' => 'Reksadana', 'amount' => 8000000, 'return' => 8.2],
                ['name' => 'Deposito', 'amount' => 5000000, 'return' => 6.5],
            ]
        ];

        return view('pages.home.advance', $data);
    }
}
