@extends('layouts.standard')

@section('title', 'Dashboard - Standard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 text-white mb-8 card-shadow">
        <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ $username }}! 👋</h1>
        <p class="opacity-90">Anda login sebagai <strong>Standard User</strong>. Kelola keuangan Anda dengan mudah menggunakan Fintrack Standard.</p>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    💰
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Saldo</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($total_balance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    📥
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($monthly_income, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    📤
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pengeluaran Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($monthly_expense, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    🎯
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Tabungan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($savings, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Chart -->
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Grafik Bulanan</h2>
            <div class="h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Transaksi Terbaru</h2>
                <a href="{{ route('standard.transactions.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recent_transactions as $transaction)
                <div class="flex items-center justify-between p-3 border border-purple-200 rounded-2xl card-shadow">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full {{ $transaction['type'] === 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $transaction['type'] === 'income' ? '📥' : '📤' }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $transaction['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ date('d M Y', strtotime($transaction['date'])) }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold {{ $transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction['type'] === 'income' ? '+' : '-' }}Rp {{ number_format($transaction['amount'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Savings Progress -->
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Progress Tabungan</h2>
                <a href="{{ route('standard.savings.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-4">
                @foreach($savings_goals as $goal)
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>{{ $goal['name'] }}</span>
                        <span>{{ number_format($goal['progress'], 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full"
                             style="width: {{ $goal['progress'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Rp {{ number_format($goal['current'], 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($goal['target'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Eisenhower Matrix Overview -->
        <div class="bg-white rounded-2xl p-6 card-shadow border border-purple-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Prioritas Keuangan</h2>
                <a href="{{ route('standard.financial-notes.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="text-red-600 text-lg">⚡</div>
                    <p class="text-sm font-medium text-gray-800 mt-1">Mendesak & Penting</p>
                    <p class="text-xs text-gray-600">{{ collect($eisenhower_data)->where('category', 'urgent_important')->count() }} item</p>
                </div>
                <div class="text-center p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="text-blue-600 text-lg">📈</div>
                    <p class="text-sm font-medium text-gray-800 mt-1">Tidak Mendesak & Penting</p>
                    <p class="text-xs text-gray-600">{{ collect($eisenhower_data)->where('category', 'not_urgent_important')->count() }} item</p>
                </div>
                <div class="text-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="text-yellow-600 text-lg">🕒</div>
                    <p class="text-sm font-medium text-gray-800 mt-1">Mendesak & Tidak Penting</p>
                    <p class="text-xs text-gray-600">{{ collect($eisenhower_data)->where('category', 'urgent_not_important')->count() }} item</p>
                </div>
                <div class="text-center p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="text-green-600 text-lg">🎯</div>
                    <p class="text-sm font-medium text-gray-800 mt-1">Tidak Mendesak & Tidak Penting</p>
                    <p class="text-xs text-gray-600">{{ collect($eisenhower_data)->where('category', 'not_urgent_not_important')->count() }} item</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($monthly_data['labels']),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($monthly_data['income']),
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: @json($monthly_data['expense']),
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
