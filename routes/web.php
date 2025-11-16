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
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login.index');
})->name('home');

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Public Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/testimonial', function () {
    $testimonials = [
        [
            'name' => 'Ahmad Rizki',
            'position' => 'Freelancer',
            'content' => 'Fintrack membantu saya mengelola keuangan dengan sangat baik.',
            'rating' => 5
        ],
        [
            'name' => 'Sari Dewi',
            'position' => 'Business Owner',
            'content' => 'Sebagai pemilik bisnis, Fintrack memberikan insight yang valuable.',
            'rating' => 5
        ]
    ];
    return view('pages.testimonial', compact('testimonials'));
})->name('testimonial');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/features', function () {
    $features = [
        ['icon' => '📊', 'title' => 'Analisis Keuangan', 'description' => 'Analisis mendalam pengeluaran dan pemasukan.'],
        ['icon' => '🎯', 'title' => 'Prioritas Eisenhower', 'description' => 'Kelola pengeluaran berdasarkan prioritas.'],
        ['icon' => '💰', 'title' => 'Manajemen Budget', 'description' => 'Atur anggaran dengan mudah.'],
        ['icon' => '📈', 'title' => 'Laporan Detail', 'description' => 'Laporan keuangan profesional.']
    ];
    return view('pages.features', compact('features'));
})->name('features');

// === ROUTES TAMBAHAN UNTUK CRUD COMPLETE ===

// Transactions CRUD Complete
Route::get('admin/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('admin/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('admin/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('admin/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('admin/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('admin/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

// Savings CRUD Complete
Route::get('admin/savings', [SavingsController::class, 'index'])->name('savings.index');
Route::get('admin/savings/create', [SavingsController::class, 'create'])->name('savings.create');
Route::post('admin/savings', [SavingsController::class, 'store'])->name('savings.store');
Route::get('admin/savings/{saving}', [SavingsController::class, 'show'])->name('savings.show');
Route::get('admin/savings/{saving}/edit', [SavingsController::class, 'edit'])->name('savings.edit');
Route::put('admin/savings/{saving}', [SavingsController::class, 'update'])->name('savings.update');
Route::delete('admin/savings/{saving}', [SavingsController::class, 'destroy'])->name('savings.destroy');

// Budgets CRUD Complete
Route::get('admin/budgets', [BudgetController::class, 'index'])->name('budgets.index');
Route::get('admin/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
Route::post('admin/budgets', [BudgetController::class, 'store'])->name('budgets.store');
Route::get('admin/budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show');
Route::get('admin/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
Route::put('admin/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
Route::delete('admin/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

// Investments CRUD Complete
Route::get('admin/investments', [InvestmentController::class, 'index'])->name('investments.index');
Route::get('admin/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
Route::post('admin/investments', [InvestmentController::class, 'store'])->name('investments.store');
Route::get('admin/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
Route::get('admin/investments/{investment}/edit', [InvestmentController::class, 'edit'])->name('investments.edit');
Route::put('admin/investments/{investment}', [InvestmentController::class, 'update'])->name('investments.update');
Route::delete('admin/investments/{investment}', [InvestmentController::class, 'destroy'])->name('investments.destroy');

// Debts CRUD Complete
Route::get('admin/debts', [DebtController::class, 'index'])->name('debts.index');
Route::get('admin/debts/create', [DebtController::class, 'create'])->name('debts.create');
Route::post('admin/debts', [DebtController::class, 'store'])->name('debts.store');
Route::get('admin/debts/{debt}', [DebtController::class, 'show'])->name('debts.show');
Route::get('admin/debts/{debt}/edit', [DebtController::class, 'edit'])->name('debts.edit');
Route::put('admin/debts/{debt}', [DebtController::class, 'update'])->name('debts.update');
Route::delete('admin/debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');

// Reports Additional Routes
Route::get('/reports/export-pdf', [ReportController::class, 'exportPDF'])->name('reports.export-pdf');
Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');

// Produk CRUD Routes
Route::get('admin/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('admin/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('admin/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('admin/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('admin/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('admin/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Admin Additional Routes
Route::get('admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

// Profile & Settings Routes
Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

Route::get('/settings', function () {
    return view('pages.settings');
})->name('settings');

// Protected Routes - Standard User (YANG SUDAH ADA - TETAP)
Route::get('/home-standard', [HomeStandardController::class, 'index'])->name('home.standard');
Route::resource('transactions', TransactionController::class);
Route::resource('savings', SavingsController::class);
Route::post('/export-data', [ReportController::class, 'exportBasic'])->name('export.basic');

// Protected Routes - Advance User (YANG SUDAH ADA - TETAP)
Route::get('/home-advance', [HomeAdvanceController::class, 'index'])->name('home.advance');
Route::resource('budgets', BudgetController::class);
Route::resource('investments', InvestmentController::class);
Route::resource('debts', DebtController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/export-advance', [ReportController::class, 'exportAdvance'])->name('export.advance');
Route::get('/cash-flow', [ReportController::class, 'cashFlow'])->name('cashflow');
Route::get('/tax-planning', [ReportController::class, 'taxPlanning'])->name('tax.planning');

// Protected Routes - Admin (YANG SUDAH ADA - TETAP)
Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');

// Logout (YANG SUDAH ADA - TETAP)
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login.index')->with('success', 'Logout berhasil!');
})->name('logout');