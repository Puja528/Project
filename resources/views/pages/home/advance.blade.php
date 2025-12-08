@extends('layouts.advance')

@section('title', 'Dashboard Advance - Fintrack')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 text-white mb-6 card-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ session('username') }}! 🚀</h1>
                    <p class="opacity-90">Anda login sebagai <strong>Advance Business User</strong>. Kelola keuangan bisnis
                        dengan tools profesional.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-sm opacity-90">Last update: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Balance -->
            <div class="bg-gray-800 rounded-xl p-5 card-shadow border border-gray-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-400 text-sm font-medium">Total Balance</h3>
                    <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                        <span class="text-purple-300">💰</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white mb-1">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
                <p class="{{ $balancePercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                    {{ $balancePercentage >= 0 ? '↗' : '↘' }}
                    {{ $balancePercentage >= 0 ? '+' : '' }}{{ number_format($balancePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Pemasukan Bulanan -->
            <div class="bg-gray-800 rounded-xl p-5 card-shadow border border-gray-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-400 text-sm font-medium">Pemasukan Bulanan</h3>
                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                        <span class="text-green-300">📥</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white mb-1">Rp {{ number_format($currentMonthIncome, 0, ',', '.') }}</p>
                <p class="{{ $incomePercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                    {{ $incomePercentage >= 0 ? '↗' : '↘' }}
                    {{ $incomePercentage >= 0 ? '+' : '' }}{{ number_format($incomePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Pengeluaran Bulanan -->
            <div class="bg-gray-800 rounded-xl p-5 card-shadow border border-gray-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-400 text-sm font-medium">Pengeluaran Bulanan</h3>
                    <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center">
                        <span class="text-red-300">📤</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white mb-1">Rp {{ number_format($currentMonthExpense, 0, ',', '.') }}</p>
                <p class="{{ $expensePercentage >= 0 ? 'text-red-400' : 'text-green-400' }} text-sm">
                    {{ $expensePercentage >= 0 ? '↗' : '↘' }}
                    {{ $expensePercentage >= 0 ? '+' : '' }}{{ number_format($expensePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Net Profit -->
            <div class="bg-gray-800 rounded-xl p-5 card-shadow border border-gray-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-400 text-sm font-medium">Net Profit</h3>
                    <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                        <span class="text-blue-300">📈</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white mb-1">Rp {{ number_format($currentMonthProfit, 0, ',', '.') }}</p>
                <p class="{{ $profitPercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                    {{ $profitPercentage >= 0 ? '↗' : '↘' }}
                    {{ $profitPercentage >= 0 ? '+' : '' }}{{ number_format($profitPercentage, 1) }}% dari bulan lalu
                </p>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Chart -->
            <div class="lg:col-span-2">
                <!-- Cash Flow Analysis -->
                <div class="bg-gray-800 rounded-2xl p-5 card-shadow border border-gray-700 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-white">Cash Flow Analysis</h2>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div>
                                <span class="text-gray-400 text-sm">Pemasukan</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-pink-500 mr-2"></div>
                                <span class="text-gray-400 text-sm">Pengeluaran</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-72">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <!-- Business Priority Matrix -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white card-shadow">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-xl font-bold mb-2">Business Priority Matrix 🎯</h2>
                            <p class="opacity-90">Kelola prioritas bisnis dengan matrix Eisenhower</p>
                        </div>
                        <a href="{{ route('advance.priority-matrix') }}"
                            class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition whitespace-nowrap">
                            Buka Matrix
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Investment Portfolio -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-2xl p-5 card-shadow border border-gray-700 h-full">
                    <!-- Header dengan judul dan tombol Tambah -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-white">Investment Portfolio</h2>
                        <a href="{{ route('advance.investments.create') }}"
                            class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                            + Tambah
                        </a>
                    </div>

                    <!-- Ringkasan Portofolio -->
                    @if($investments->count() > 0)
                        <div class="mt-6 p-4 bg-gray-900/50 rounded-xl">
                            <h3 class="font-bold text-white mb-4">Ringkasan Portofolio</h3>

                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-400 text-sm">{{ $investments->count() }} portfolio aktif</span>
                                    <span class="text-white font-bold text-lg">
                                        Rp {{ number_format($investments->sum('current_value'), 0, ',', '.') }}
                                    </span>
                                </div>

                                @php
                                    $totalInitial = $investments->sum('initial_amount');
                                    $totalCurrent = $investments->sum('current_value');
                                    $totalReturn = $totalInitial > 0 ? (($totalCurrent - $totalInitial) / $totalInitial * 100) : 0;
                                    $totalProfit = $totalCurrent - $totalInitial;
                                @endphp

                                <div class="flex justify-between items-center mt-3">
                                    <div>
                                        <p class="text-gray-400 text-xs mb-1">Total Return</p>
                                        <p
                                            class="{{ $totalReturn >= 0 ? 'text-green-400' : 'text-red-400' }} font-semibold text-sm">
                                            {{ $totalReturn >= 0 ? '+' : '' }}{{ number_format($totalReturn, 1) }}%
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-400 text-xs mb-1">
                                            {{ $totalProfit >= 0 ? 'Keuntungan' : 'Kerugian' }}
                                        </p>
                                        <p class="text-gray-300 text-sm font-medium">
                                            Rp {{ number_format(abs($totalProfit), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Breakdown Stats -->
                            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-gray-700">
                                <div>
                                    <p class="text-gray-400 text-xs">Rata-rata Return</p>
                                    @php
                                        $avgReturn = $investments->avg('return_percentage');
                                    @endphp
                                    <p class="{{ $avgReturn >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm font-semibold">
                                        {{ $avgReturn >= 0 ? '+' : '' }}{{ number_format($avgReturn, 1) }}%
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs">Risiko Teratas</p>
                                    <p class="text-white text-sm font-semibold">
                                        @php
                                            $topRisk = $investments->groupBy('risk_level')
                                                ->map->count()
                                                ->sortDesc()
                                                ->keys()
                                                ->first();
                                        @endphp
                                        {{ ucfirst($topRisk ?? 'Medium') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs">Investasi Aktif</p>
                                    <p class="text-white text-sm font-semibold">
                                        {{ $investments->where('status', 'active')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Spacious Version -->
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">Quick Actions</h2>
            <p class="text-gray-400">Akses cepat ke fitur utama Fintrack</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Transaksi -->
            <a href="{{ route('advance.transactions.index') }}"
                class="group bg-gray-800/50 hover:bg-gray-800 p-6 rounded-2xl transition-all duration-300 border border-gray-700/50 hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/5">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 flex items-center justify-center mb-4 group-hover:from-purple-500/30 group-hover:to-purple-600/20 transition-all duration-300">
                        <span class="text-3xl">💰</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-300 transition-colors">Transaksi
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Kelola semua transaksi keuangan bisnis Anda dengan mudah
                    </p>
                    <div
                        class="text-purple-400 text-sm font-medium flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span>Buka Transaksi</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Anggaran -->
            <a href="{{ route('advance.budgets.index') }}"
                class="group bg-gray-800/50 hover:bg-gray-800 p-6 rounded-2xl transition-all duration-300 border border-gray-700/50 hover:border-pink-500/50 hover:shadow-xl hover:shadow-pink-500/5">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-500/20 to-pink-600/10 flex items-center justify-center mb-4 group-hover:from-pink-500/30 group-hover:to-pink-600/20 transition-all duration-300">
                        <span class="text-3xl">📊</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-pink-300 transition-colors">Anggaran</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Atur dan pantau anggaran bisnis untuk pengelolaan yang optimal
                    </p>
                    <div
                        class="text-pink-400 text-sm font-medium flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span>Kelola Anggaran</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Laporan -->
            <a href="{{ route('advance.reports.index') }}"
                class="group bg-gray-800/50 hover:bg-gray-800 p-6 rounded-2xl transition-all duration-300 border border-gray-700/50 hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/5">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 flex items-center justify-center mb-4 group-hover:from-blue-500/30 group-hover:to-blue-600/20 transition-all duration-300">
                        <span class="text-3xl">📈</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">Laporan</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Analisis laporan keuangan bisnis dengan data yang komprehensif
                    </p>
                    <div
                        class="text-blue-400 text-sm font-medium flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span>Lihat Laporan</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Cash Flow -->
            <a href="{{ route('advance.reports.cashflow') }}"
                class="group bg-gray-800/50 hover:bg-gray-800 p-6 rounded-2xl transition-all duration-300 border border-gray-700/50 hover:border-green-500/50 hover:shadow-xl hover:shadow-green-500/5">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500/20 to-green-600/10 flex items-center justify-center mb-4 group-hover:from-green-500/30 group-hover:to-green-600/20 transition-all duration-300">
                        <span class="text-3xl">💸</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-300 transition-colors">Cash Flow
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Pantau dan analisis arus kas bisnis untuk kesehatan keuangan
                    </p>
                    <div
                        class="text-green-400 text-sm font-medium flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span>Analisis Cash Flow</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <script>
        // Chart.js dengan data dinamis dari database
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Pemasukan',
                    data: @json($monthlyIncome),
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: @json($monthlyExpense),
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleColor: '#FFFFFF',
                        bodyColor: '#D1D5DB',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: Rp ${context.raw.toLocaleString('id-ID')} juta`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#9CA3AF',
                            callback: function (value) {
                                return 'Rp ' + value + ' jt';
                            }
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        },
                        border: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    </script>
    </div>
@endsection
