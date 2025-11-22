<?php

namespace App\Http\Controllers;

class HomeStandardController extends Controller
{
    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Data untuk standard user
        $data = [
            'username'        => session('username'),
            'total_balance'   => 12500000,
            'monthly_income'  => 8500000,
            'monthly_expense' => 7250000,
            'savings'         => 3250000,
            'monthly_data'    => [
                'labels'  => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'income'  => [7500, 8000, 8200, 7800, 8500, 9000, 8700, 9200, 8800, 8500, 8900, 9300],
                'expense' => [6500, 7000, 7200, 6800, 7500, 8000, 7700, 8200, 7800, 7500, 7900, 8300],
            ],
            'eisenhower_data' => [
                ['task' => 'Bayar Listrik', 'amount' => 450000, 'category' => 'urgent_important', 'due_date' => '2024-01-15'],
                ['task' => 'Belanja Bulanan', 'amount' => 1200000, 'category' => 'urgent_important', 'due_date' => '2024-01-20'],
                ['task' => 'Investasi Saham', 'amount' => 2000000, 'category' => 'not_urgent_important', 'due_date' => '2024-01-30'],
                ['task' => 'Renovasi Rumah', 'amount' => 5000000, 'category' => 'not_urgent_important', 'due_date' => '2024-02-28'],
                ['task' => 'Makan di Restoran', 'amount' => 350000, 'category' => 'urgent_not_important', 'due_date' => '2024-01-10'],
                ['task' => 'Belanja Online', 'amount' => 750000, 'category' => 'not_urgent_not_important', 'due_date' => '2024-01-25'],
            ],
        ];

        return view('pages.home.standard', $data);
    }
}