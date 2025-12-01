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
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Total Balance</h3>
                <p class="text-3xl font-bold text-white mt-2">Rp 25,500,000</p>
                <p class="text-green-400 text-sm mt-2">+8.5% dari bulan lalu</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Pemasukan Bulanan</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp 18,500,000</p>
                <p class="text-green-400 text-sm mt-2">+12% dari bulan lalu</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Pengeluaran Bulanan</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp 13,250,000</p>
                <p class="text-red-400 text-sm mt-2">+5% dari bulan lalu</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <h3 class="text-gray-400 text-sm font-medium">Net Profit</h3>
                <p class="text-2xl font-bold text-white mt-2">Rp 5,250,000</p>
                <p class="text-green-400 text-sm mt-2">+15% dari bulan lalu</p>
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
                    <div class="flex justify-between items-center p-4 bg-gray-700 rounded-lg">
                        <div>
                            <h3 class="font-semibold text-white">Saham BBCA</h3>
                            <p class="text-gray-400 text-sm">Return: +25%</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-semibold">Rp 12,500,000</p>
                            <p class="text-green-400 text-sm">Active</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-700 rounded-lg">
                        <div>
                            <h3 class="font-semibold text-white">Reksadana</h3>
                            <p class="text-gray-400 text-sm">Return: +8.2%</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-semibold">Rp 8,000,000</p>
                            <p class="text-green-400 text-sm">Active</p>
                        </div>
                    </div>
                </div>
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

        <!-- Quick Actions - PERBAIKAN ROUTE DI SINI -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('transactions.index') }}"
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
        // Chart.js Implementation untuk Advance User
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pemasukan',
                    data: [18500, 19200, 17800, 21000, 19500, 22000, 23500, 22800, 24200, 25800, 24500, 26500],
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: [13250, 14500, 12800, 15600, 14200, 16800, 15800, 17200, 16500, 18200, 17500, 19200],
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }
                ]
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#FFFFFF'
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
