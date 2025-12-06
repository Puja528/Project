<?php

use App\Http\Controllers\HomeStandardController;
use App\Http\Controllers\HomeAdvanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PriorityMatrixController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Public Routes - Guest
Route::get('/', function () {
    return view('pages.home.guest');
})->name('home.guest');

// Public Pages - Hanya untuk Guest
Route::get('/about', function () {
    return view('pages.guest.about');
})->name('about');

Route::get('/testimonial', function () {
    $testimonials = [
        [
            'name' => 'Ahmad Rizki',
            'position' => 'Freelancer',
            'content' => 'Fintrack membantu saya mengelola keuangan dengan sangat baik. Interface yang user-friendly dan fitur yang lengkap membuat pengelolaan keuangan menjadi lebih mudah.',
            'rating' => 5
        ],
        [
            'name' => 'Berlindi Achica',
            'position' => 'Business Owner',
            'content' => 'Sebagai pemilik bisnis, Fintrack memberikan insight yang valuable untuk pengambilan keputusan. Laporan keuangan yang detail sangat membantu.',
            'rating' => 5
        ],
        [
            'name' => 'Budi Santoso',
            'position' => 'Karyawan Swasta',
            'content' => 'Saya bisa menabung lebih teratur sejak menggunakan Fintrack. Fitur target tabungan sangat membantu mencapai tujuan finansial.',
            'rating' => 5
        ],
        [
            'name' => 'Maya Sari',
            'position' => 'Digital Marketer',
            'content' => 'Matriks Eisenhower membantu saya memprioritaskan pengeluaran dengan bijak. Sangat recommended!',
            'rating' => 5
        ],
        [
            'name' => 'Rizki Pratama',
            'position' => 'Mahasiswa',
            'content' => 'Aplikasi yang cocok untuk anak muda yang ingin belajar mengelola keuangan. Gratis dan fiturnya lengkap!',
            'rating' => 5
        ],
        [
            'name' => 'Dewi Lestari',
            'position' => 'Ibu Rumah Tangga',
            'content' => 'Membantu mengatur pengeluaran rumah tangga dengan lebih terstruktur. Sangat bermanfaat untuk keluarga.',
            'rating' => 5
        ]
    ];
    return view('pages.guest.testimonial', compact('testimonials'));
})->name('testimonial');

Route::get('/contact', function () {
    return view('pages.guest.contact');
})->name('contact');

Route::get('/features', function () {
    $features = [
        [
            'icon' => '📊',
            'title' => 'Analisis Keuangan Mendalam',
            'description' => 'Dapatkan insight lengkap tentang kondisi keuangan Anda dengan analisis real-time dan laporan detail'
        ],
        [
            'icon' => '🎯',
            'title' => 'Prioritas Eisenhower',
            'description' => 'Kelola pengeluaran berdasarkan skala prioritas untuk pengambilan keputusan yang lebih bijak'
        ],
        [
            'icon' => '💰',
            'title' => 'Manajemen Budget',
            'description' => 'Atur anggaran dengan mudah dan pantau pengeluaran agar tidak melebihi batas yang ditetapkan'
        ],
        [
            'icon' => '📈',
            'title' => 'Laporan Detail',
            'description' => 'Generate laporan keuangan profesional dengan berbagai format untuk kebutuhan bisnis dan pribadi'
        ],
        [
            'icon' => '🎯',
            'title' => 'Target Tabungan',
            'description' => 'Tetapkan tujuan tabungan dan pantau progresnya dengan sistem reminder yang smart'
        ],
        [
            'icon' => '🔔',
            'title' => 'Notifikasi Real-time',
            'description' => 'Dapatkan pemberitahuan langsung untuk transaksi, tagihan, dan pencapaian target finansial'
        ]
    ];
    return view('pages.guest.features', compact('features'));
})->name('features');

// Protected Routes
Route::middleware(['auth.custom'])->group(function () {
    // Standard User Routes
    Route::get('/home-standard', [HomeStandardController::class, 'index'])->name('home.standard');

    // Advance User Routes dengan prefix yang benar
    Route::prefix('advance')->group(function () {
        Route::get('/home', [HomeAdvanceController::class, 'index'])->name('home.advance');

        //Matrix Routes
        Route::get('/priority-matrix', [PriorityMatrixController::class, 'index'])->name('advance.priority-matrix');
        Route::get('/priority-matrix/{id}', [PriorityMatrixController::class, 'show'])->name('advance.priority-matrix.detail');

        // Budget routes
        Route::get('/budgets', [BudgetController::class, 'index'])->name('advance.budgets.index');
        Route::get('/budgets/create', [BudgetController::class, 'create'])->name('advance.budgets.create');
        Route::post('/budgets/store', [BudgetController::class, 'store'])->name('advance.budgets.store');
        Route::get('/budgets/{id}/edit', [BudgetController::class, 'edit'])->name('advance.budgets.edit');
        Route::put('/budgets/{id}', [BudgetController::class, 'update'])->name('advance.budgets.update');
        Route::delete('/budgets/{id}', [BudgetController::class, 'destroy'])->name('advance.budgets.destroy');

        // Investment routes
        Route::get('/investments', [InvestmentController::class, 'index'])->name('advance.investments.index');
        Route::get('/investments/create', [InvestmentController::class, 'create'])->name('advance.investments.create');
        Route::post('/investments', [InvestmentController::class, 'store'])->name('advance.investments.store');
        Route::post('/investments/{id}/edit', [InvestmentController::class, 'edit'])->name('advance.investments.edit');
        Route::post('/investments/{id}', [InvestmentController::class, 'update'])->name('advance.investments.update');
        Route::post('/investments/{id}', [InvestmentController::class, 'destroy'])->name('advance.investments.destroy');

        // Debt routes
        Route::get('/debts', [DebtController::class, 'index'])->name('advance.debts.index');
        Route::get('/debts/create', [DebtController::class, 'create'])->name('advance.debts.create');
        Route::post('/debts', [DebtController::class, 'store'])->name('advance.debts.store');
        Route::get('/debts/{id}/edit', [DebtController::class, 'edit'])->name('advance.debts.edit');
        Route::put('/debts/{id}', [DebtController::class, 'update'])->name('advance.debts.update');
        Route::delete('/debts/{id}', [DebtController::class, 'destroy'])->name('advance.debts.destroy');

        // Report routes
        Route::get('/reports', [ReportController::class, 'index'])->name('advance.reports.index');
        Route::post('/reports/export-advance', [ReportController::class, 'exportAdvance'])->name('advance.export.advance');
        Route::get('/reports/cash-flow', [ReportController::class, 'cashFlow'])->name('advance.reports.cashflow');
        Route::get('/reports/tax-planning', [ReportController::class, 'taxPlanning'])->name('advance.reports.tax');

        // Transactions routes
        Route::get('/transactions', [TransactionController::class, 'index'])->name('advance.transactions.index');
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('advance.transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('advance.transactions.store');
        Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('advance.transactions.edit');
        Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('advance.transactions.update');
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('advance.transactions.destroy');
    });

    // Common routes untuk semua user
    Route::resource('transactions', TransactionController::class);
    Route::resource('savings', SavingsController::class);

    // Export basic
    Route::post('/export-basic', [ReportController::class, 'exportBasic'])->name('reports.export.basic');
    Route::post('/export-basic', [TransactionController::class, 'exportBasic'])->name('export.basic');

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');
    });
});

// Logout
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('home.guest')->with('success', 'Logout berhasil!');
})->name('logout');
