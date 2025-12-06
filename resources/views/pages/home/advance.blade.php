@extends('layouts.advance')

@section('title', 'Dashboard Advance - Fintrack')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 text-white mb-8 card-shadow">
            <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ session('username') }}! 🚀</h1>
            <p class="opacity-90">Anda login sebagai <strong>Advance Business User</strong>. Kelola keuangan bisnis dengan
                tools profesional.</p>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Balance -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Total Balance</h3>
                <p class="text-3xl font-bold text-white mt-2">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
                <p class="{{ $balancePercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm mt-2">
                    {{ $balancePercentage >= 0 ? '+' : '' }}{{ number_format($balancePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Pemasukan Bulanan -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Pemasukan Bulanan</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($currentMonthIncome, 0, ',', '.') }}</p>
                <p class="{{ $incomePercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm mt-2">
                    {{ $incomePercentage >= 0 ? '+' : '' }}{{ number_format($incomePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Pengeluaran Bulanan -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Pengeluaran Bulanan</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($currentMonthExpense, 0, ',', '.') }}</p>
                <p class="{{ $expensePercentage >= 0 ? 'text-red-400' : 'text-green-400' }} text-sm mt-2">
                    {{ $expensePercentage >= 0 ? '+' : '' }}{{ number_format($expensePercentage, 1) }}% dari bulan lalu
                </p>
            </div>

            <!-- Net Profit -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Net Profit</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($currentMonthProfit, 0, ',', '.') }}</p>
                <p class="{{ $profitPercentage >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm mt-2">
                    {{ $profitPercentage >= 0 ? '+' : '' }}{{ number_format($profitPercentage, 1) }}% dari bulan lalu
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Grafik Keuangan -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h2 class="text-xl font-bold text-white mb-6">Cash Flow Analysis</h2>
                <div class="h-80">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>

            <!-- Portfolio Investasi -->
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h2 class="text-xl font-bold text-white mb-6">Investment Portfolio</h2>
                <div class="space-y-4">
                    @forelse($investments as $investment)
                        <div class="flex justify-between items-center p-4 bg-gray-700 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-white">{{ $investment->name ?? 'N/A' }}</h3>
                                <p class="text-gray-400 text-sm">{{ $investment->type ?? 'Unknown' }} •
                                    {{ $investment->risk_level ?? 'Medium' }}</p>
                                <p class="text-gray-400 text-sm mt-1">
                                    Return:
                                    <span class="{{ $investment->return_percentage >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $investment->return_percentage >= 0 ? '+' : '' }}{{ number_format($investment->return_percentage, 1) }}%
                                    </span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-semibold">Rp
                                    {{ number_format($investment->current_value, 0, ',', '.') }}</p>
                                <p class="text-green-400 text-sm">
                                    {{ $investment->current_value > 0 ? 'Active' : 'Closed' }}
                                </p>
                                <p class="text-gray-400 text-xs mt-1">
                                    Mulai: {{ \Carbon\Carbon::parse($investment->start_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <p>Belum ada data investasi</p>
                            <a href="{{ route('advance.investments.create') }}"
                                class="text-purple-400 hover:text-purple-300 mt-2 inline-block">
                                + Tambah Investasi
                            </a>
                        </div>
                    @endforelse

                    @if($investments->count() > 0)
                        <!-- Total Investment Summary -->
                        <div class="mt-6 p-4 bg-gray-900 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold text-white">Total Investasi</h3>
                                    <p class="text-gray-400 text-sm">{{ $investments->count() }} portfolio aktif</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-white font-semibold text-xl">
                                        Rp {{ number_format($investments->sum('current_value'), 0, ',', '.') }}
                                    </p>
                                    @php
                                        $totalInitial = $investments->sum('initial_amount');
                                        $totalCurrent = $investments->sum('current_value');
                                        $totalReturn = $totalInitial > 0 ? (($totalCurrent - $totalInitial) / $totalInitial * 100) : 0;
                                    @endphp
                                    <p class="{{ $totalReturn >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                        Total Return: {{ $totalReturn >= 0 ? '+' : '' }}{{ number_format($totalReturn, 1) }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Business Priority Matrix Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white card-shadow mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold mb-2">Business Priority Matrix 🎯</h2>
                        <p class="opacity-90">Kelola prioritas bisnis dengan matrix Eisenhower</p>
                    </div>
                    <a href="{{ route('advance.priority-matrix') }}"
                        class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition">
                        Buka Matrix
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('advance.transactions.index') }}"
                    class="bg-purple-600 hover:bg-purple-700 p-4 rounded-lg text-center transition">
                    <div class="text-2xl mb-2">💰</div>
                    <p class="font-semibold">Transaksi</p>
                </a>
                <a href="{{ route('advance.budgets.index') }}"
                    class="bg-pink-600 hover:bg-pink-700 p-4 rounded-lg text-center transition">
                    <div class="text-2xl mb-2">📊</div>
                    <p class="font-semibold">Anggaran</p>
                </a>
                <a href="{{ route('advance.reports.index') }}"
                    class="bg-blue-600 hover:bg-blue-700 p-4 rounded-lg text-center transition">
                    <div class="text-2xl mb-2">📈</div>
                    <p class="font-semibold">Laporan</p>
                </a>
                <a href="{{ route('advance.reports.cashflow') }}"
                    class="bg-green-600 hover:bg-green-700 p-4 rounded-lg text-center transition">
                    <div class="text-2xl mb-2">💸</div>
                    <p class="font-semibold">Cash Flow</p>
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
                        label: 'Pemasukan (juta Rp)',
                        data: @json($monthlyIncome),
                        borderColor: '#8B5CF6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran (juta Rp)',
                        data: @json($monthlyExpense),
                        borderColor: '#EC4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#FFFFFF'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: Rp ${context.raw.toFixed(1)} juta`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#FFFFFF',
                                callback: function (value) {
                                    return 'Rp ' + value.toFixed(0) + ' jt';
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            });
        </script>
@endsection
