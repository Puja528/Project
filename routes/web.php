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
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Public Routes - Guest
Route::get('/', function () {
    return view('pages.guest.home');
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


// Protected Routes - Standard User
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/home-standard', [HomeStandardController::class, 'index'])->name('home.standard');

    // Protected Routes - Advance User
    Route::get('/home-advance', [HomeAdvanceController::class, 'index'])->name('home.advance');
    Route::resource('transactions', TransactionController::class);
    Route::resource('savings', SavingsController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('investments', InvestmentController::class);
    Route::resource('debts', DebtController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/export-advance', [ReportController::class, 'exportAdvance'])->name('export.advance');
    Route::get('/cash-flow', [ReportController::class, 'cashFlow'])->name('cashflow');
    Route::get('/tax-planning', [ReportController::class, 'taxPlanning'])->name('tax.planning');

    // Protected Routes - Admin
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');

    // Admin User Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});

// Logout
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('home.guest')->with('success', 'Logout berhasil!');
})->name('logout');

Route::get('/test', function () {
    return 'Test page';
})->middleware('auth.custom');