<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

            $totalUsers = User::count();
            $activeUsers = User::where('status', 'active')->count();
            $standardUsers = User::where('type', 'standard')->count();
            $advanceUsers = User::where('type', 'advance')->count();
            $adminUsers = User::where('type', 'admin')->count();

       $stats = [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'total_transactions' => 0, // Ganti dengan query jika ada tabel transactions
            'total_revenue' => 0,      // Ganti dengan query jika ada tabel transactions
            'standard_users' => $standardUsers,
            'advance_users' => $advanceUsers,
            'admin_users' => $adminUsers, // Tambahkan admin user untuk kelengkapan
            'user_growth' => $this->getUserGrowthData(),
            'revenue_growth' => [0, 0, 0, 0, 0, 0],
            'user_growth_labels' => $this->getUserGrowthLabels(), // TAMBAHKAN INI

        ];
        $stats['total_users'] = $totalUsers;

        return view('pages.admin.dashboard', compact('stats'));
    }

    private function getUserGrowthData()
    {
        // Mendapatkan label bulan untuk 6 bulan terakhir
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $userCounts = [];
        foreach ($months as $month) {
            $count = User::whereYear('created_at', substr($month, 0, 4))
                         ->whereMonth('created_at', substr($month, 5, 2))
                         ->count();
            $userCounts[] = $count;
        }

        // Mengkonversi ke data kumulatif (jika ingin menampilkan total pertumbuhan dari waktu ke waktu)
        // Jika Anda ingin menampilkan pertumbuhan bulan ke bulan (bulan ini bertambah X user)
        // gunakan $userCounts, tetapi jika ingin total kumulatif, gunakan yang ini:
        $cumulativeUsers = [];
        $runningTotal = 0;
        foreach ($userCounts as $count) {
            $runningTotal += $count;
            $cumulativeUsers[] = $runningTotal;
        }

        return $cumulativeUsers;
    }

    public function users()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $users = User::latest()->get();

        // Gunakan data dummy sementara untuk menghindari error
        $stats = [
            'total_users' => $users->count(),
            'active_users' => $users->count(), // Asumsikan semua aktif sementara
            'standard_users' => $users->where('type', 'standard')->count(),
            'advance_users' => $users->where('type', 'advance')->count(),
        ];

        // Jika kolom status belum ada, set default active untuk semua user
        foreach ($users as $user) {
            if (!isset($user->status)) {
                $user->status = 'active';
            }
            if (!isset($user->type)) {
                $user->type = 'standard';
            }
        }

        return view('pages.admin.users', compact('users', 'stats'));
    }

    public function createUser()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.admin.users-create');
    }

    public function storeUser(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

            'type' => 'required|in:standard,advance,admin',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser($id)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $user = User::findOrFail($id);
        return view('pages.admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|in:standard,advance',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

   public function transactions()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

       $transactions = DB::table('transactions')
                        ->join('users', 'transactions.user_id', '=', 'users.id')
                        ->select(
                            'transactions.id',
                            'users.name as user_name',
                            'transactions.type',
                            'transactions.amount',
                            'transactions.category',
                            'transactions.date'
                        )
                        ->orderBy('transactions.date', 'desc')
                        ->get()
                        // Mapping hasil join agar key 'user' sesuai dengan blade view
                        ->map(function ($item) {
                            return (array) [
                                'id' => $item->id,
                                'user' => $item->user_name,
                                'type' => $item->type,
                                'amount' => $item->amount,
                                'category' => $item->category,
                                'date' => $item->date,
                            ];
                        });

        // --- 2. HITUNG STATISTIK AGREGAT ---
        $stats = DB::table('transactions')
                ->selectRaw('COUNT(id) as total_transactions')
                ->selectRaw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income')
                ->selectRaw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense')
                ->selectRaw('AVG(amount) as avg_transaction')
                ->first();

        $transactionStats = [
            'total_transactions' => $stats->total_transactions ?? 0,
            'total_income' => $stats->total_income ?? 0,
            'total_expense' => $stats->total_expense ?? 0,
            // Bulatkan nilai rata-rata
            'avg_transaction' => round($stats->avg_transaction ?? 0),
        ];

        // Mengirimkan kedua data ke view
        return view('pages.admin.transactions', compact('transactions', 'transactionStats'));
    }

   public function analytics()
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Mendapatkan label bulan (Y-m) untuk 6 bulan terakhir
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        // Data Dinamis
        $userGrowthLabels = $this->getUserGrowthLabels(); // Mengambil nama bulan (M)
        $userGrowthData = $this->getUserGrowthData(); // Data pertumbuhan user kumulatif
        $userTypeDistribution = $this->getUsersTypeDistribution(); // Distribusi tipe user
        $revenueGrowthData = $this->getMonthlyRevenueGrowthData($months); // Data pertumbuhan revenue kumulatif
        $transactionTrends = $this->getMonthlyTransactionTrends($months); // Data trend transaksi (Income/Expense)

        $totalUsers = $userTypeDistribution['standard'] + $userTypeDistribution['advance'] + $userTypeDistribution['admin'];
        $activeUsers = User::where('status', 'active')->count();
        // Asumsi Monthly Revenue adalah total income bulan terakhir
        $monthlyRevenue = end($transactionTrends['income']);

        // Data Analytics
        $analytics = [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'monthly_revenue' => $monthlyRevenue,

            // Data untuk Chart
            'user_growth' => $userGrowthData, // Kumulatif
            'user_growth_labels' => $userGrowthLabels, // Label bulan (e.g., Jan, Feb)
            'revenue_growth' => $revenueGrowthData, // Kumulatif
            'user_type_data' => array_values($userTypeDistribution),

            'transaction_trends' => [
                'labels' => $userGrowthLabels,
                'income' => $transactionTrends['income'], // Income per bulan
                'expense' => $transactionTrends['expense'], // Expense per bulan
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

    // --- Menghitung Statistik Kartu Laporan (DINAMIS DARI $reports) ---
    $totalReports = count($reports);
    $revenueReports = 0;
    $totalSizeMB = 0; // Asumsi bahwa 1 laporan Revenue/Transaction memiliki ukuran 3MB, User Report 1MB
    $totalAmountSum = 0;

    foreach ($reports as $report) {
        if ($report['type'] === 'Revenue Report') {
            $revenueReports++;
            $totalSizeMB += 3;
            $totalAmountSum += $report['total_amount'] ?? 0;
        } elseif ($report['type'] === 'Transaction Report') {
            $totalSizeMB += 3;
            $totalAmountSum += $report['total_amount'] ?? 0;
        } elseif ($report['type'] === 'User Growth Report') {
            $totalSizeMB += 1;
        }
    }

    $avgReportSize = $totalReports > 0 ? round($totalSizeMB / $totalReports, 1) : 0;

    // Asumsi: Kita hanya menghitung laporan yang "generated this month" (Januari 2024)
    $reportsThisMonth = collect($reports)->filter(function ($report) {
        return now()->format('Y-m') === now()->create($report['generated_at'])->format('Y-m');
    })->count();

    $reportStats = [
        'total_reports' => $totalReports,
        'reports_this_month' => $reportsThisMonth, // Menggunakan perhitungan yang lebih spesifik
        'revenue_reports_count' => $revenueReports,
        'avg_report_size' => $avgReportSize, // Dalam MB
    ];

    // Mengirimkan kedua data ke view
    return view('pages.admin.reports', compact('reports', 'reportStats'));
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

    public function generateReport(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'admin') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        // Logic untuk generate report
        return back()->with('success', 'Report berhasil digenerate.');
    }

    private function getUserGrowthLabels()
    {
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = now()->subMonths($i)->format('M'); // Contoh: Jan, Feb, Mar
        }
        return $labels;
    }

    private function getMonthlyRevenueGrowthData($months)
    {
        $revenueData = [];
        $runningTotalRevenue = 0;

        foreach ($months as $month) {
            // Ambil total 'income' (atau 'revenue' jika ada kolom spesifik) untuk bulan ini
            $monthlyIncome = DB::table('transactions')
                               ->where('type', 'income') // Hanya hitung income sebagai revenue
                               ->whereYear('date', substr($month, 0, 4))
                               ->whereMonth('date', substr($month, 5, 2))
                               ->sum('amount');

            // Perhitungan kumulatif (jika ingin menampilkan total pendapatan dari waktu ke waktu)
            $runningTotalRevenue += $monthlyIncome;
            $revenueData[] = $runningTotalRevenue;
        }

        return $revenueData;
    }

    // Helper function untuk mendapatkan distribusi tipe user (Standard, Advance, Admin)
    private function getUsersTypeDistribution()
    {
        return [
            'standard' => User::where('type', 'standard')->count(),
            'advance' => User::where('type', 'advance')->count(),
            'admin' => User::where('type', 'admin')->count(),
        ];
    }

    // Helper function untuk mendapatkan trend Income dan Expense per bulan
    private function getMonthlyTransactionTrends($months)
    {
        $incomeData = [];
        $expenseData = [];

        foreach ($months as $month) {
            $year = substr($month, 0, 4);
            $mon = substr($month, 5, 2);

            // Income
            $income = DB::table('transactions')
                        ->where('type', 'income')
                        ->whereYear('date', $year)
                        ->whereMonth('date', $mon)
                        ->sum('amount');
            $incomeData[] = $income;

            // Expense
            $expense = DB::table('transactions')
                         ->where('type', 'expense')
                         ->whereYear('date', $year)
                         ->whereMonth('date', $mon)
                         ->sum('amount');
            $expenseData[] = $expense;
        }

        return [
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }
}
