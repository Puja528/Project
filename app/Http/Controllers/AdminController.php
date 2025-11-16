<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $stats = [
            'total_users' => 150,
            'active_users' => 142,
            'total_transactions' => 1250,
            'total_revenue' => 185000000,
            'standard_users' => 120,
            'advance_users' => 30,
            // Tambahkan data untuk chart
            'user_growth' => [100, 110, 120, 130, 140, 150], // Data untuk 6 bulan
            'revenue_growth' => [120000000, 135000000, 150000000, 165000000, 175000000, 185000000] // Data untuk 6 bulan
        ];

        return view('pages.admin.dashboard', compact('stats'));
    }

    public function users()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $users = [
            [
                'id' => 1,
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'type' => 'standard',
                'status' => 'active',
                'joined_date' => '2024-01-15'
            ],
            [
                'id' => 2,
                'name' => 'Sari Dewi',
                'email' => 'sari@email.com',
                'type' => 'advance',
                'status' => 'active',
                'joined_date' => '2024-01-10'
            ],
            [
                'id' => 3,
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@email.com',
                'type' => 'standard',
                'status' => 'inactive',
                'joined_date' => '2024-01-05'
            ]
        ];

        return view('pages.admin.users', compact('users'));
    }

    public function transactions()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $transactions = [
            [
                'id' => 1,
                'user' => 'Budi Santoso',
                'type' => 'expense',
                'amount' => 1200000,
                'category' => 'belanja',
                'date' => '2024-01-15'
            ],
            [
                'id' => 2,
                'user' => 'Sari Dewi',
                'type' => 'income',
                'amount' => 5000000,
                'category' => 'gaji',
                'date' => '2024-01-14'
            ],
            [
                'id' => 3,
                'user' => 'Ahmad Rizki',
                'type' => 'expense',
                'amount' => 750000,
                'category' => 'transportasi',
                'date' => '2024-01-13'
            ]
        ];

        return view('pages.admin.transactions', compact('transactions'));
    }

    public function analytics()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $analytics = [
            'user_growth' => [100, 120, 135, 142, 150],
            'revenue_growth' => [120000000, 145000000, 168000000, 175000000, 185000000],
            'active_users' => [85, 92, 105, 128, 142],
            'transaction_trends' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'income' => [45, 52, 48, 55, 58, 62],
                'expense' => [30, 35, 32, 38, 40, 42]
            ]
        ];

        return view('pages.admin.analytics', compact('analytics'));
    }

    public function reports()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $reports = [
            [
                'id' => 1,
                'type' => 'Revenue Report',
                'period' => 'Januari 2024',
                'total_amount' => 185000000,
                'generated_at' => '2024-01-31'
            ],
            [
                'id' => 2,
                'type' => 'User Growth Report',
                'period' => 'Januari 2024',
                'total_amount' => null,
                'generated_at' => '2024-01-31'
            ],
            [
                'id' => 3,
                'type' => 'Transaction Report',
                'period' => 'Desember 2023',
                'total_amount' => 175000000,
                'generated_at' => '2023-12-31'
            ]
        ];

        return view('pages.admin.reports', compact('reports'));
    }

    public function activityLogs()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $logs = [
            [
                'id' => 1,
                'admin' => 'Admin System',
                'action' => 'user_login',
                'description' => 'User budi@email.com logged in',
                'ip_address' => '192.168.1.100',
                'created_at' => '2024-01-20 08:30:15'
            ],
            [
                'id' => 2,
                'admin' => 'Admin System',
                'action' => 'user_registration',
                'description' => 'New user ahmad@email.com registered',
                'ip_address' => '192.168.1.101',
                'created_at' => '2024-01-20 10:15:22'
            ],
            [
                'id' => 3,
                'admin' => 'Admin System',
                'action' => 'transaction_created',
                'description' => 'User sari@email.com created new transaction',
                'ip_address' => '192.168.1.102',
                'created_at' => '2024-01-20 14:45:30'
            ]
        ];

        return view('pages.admin.activity-logs', compact('logs'));
    }

    // Method untuk handle actions
    public function updateUserStatus(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Logic untuk update status user
        return back()->with('success', 'Status user berhasil diupdate.');
    }

    public function deleteUser($id)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Logic untuk delete user
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function generateReport(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Logic untuk generate report
        return back()->with('success', 'Report berhasil digenerate.');
    }
}