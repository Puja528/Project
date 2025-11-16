@extends('layouts.advance')

@section('title', 'Laporan Keuangan - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Laporan Keuangan Profesional</h1>
        <form action="{{ route('export.advance') }}" method="POST">
            @csrf
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                📊 Ekspor Laporan
            </button>
        </form>
    </div>

    <!-- Report Summary -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Pemasukan</h3>
            <p class="text-2xl font-bold text-green-400 mt-2">Rp 222,000,000</p>
            <p class="text-gray-500 text-sm">Tahun 2024</p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Pengeluaran</h3>
            <p class="text-2xl font-bold text-red-400 mt-2">Rp 159,000,000</p>
            <p class="text-gray-500 text-sm">Tahun 2024</p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Laba Bersih</h3>
            <p class="text-2xl font-bold text-blue-400 mt-2">Rp 63,000,000</p>
            <p class="text-gray-500 text-sm">Tahun 2024</p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Tax Estimation</h3>
            <p class="text-2xl font-bold text-yellow-400 mt-2">Rp 7,560,000</p>
            <p class="text-gray-500 text-sm">PPh 12%</p>
        </div>
    </div>

    <!-- Monthly Reports -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8">
        <h2 class="text-xl font-bold text-white mb-6">Laporan Bulanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pemasukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pengeluaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Laba Bersih</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Savings Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                            {{ $report['period'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">
                            Rp {{ number_format($report['total_income'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">
                            Rp {{ number_format($report['total_expense'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-400">
                            Rp {{ number_format($report['net_income'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-400">
                            {{ $report['savings_rate'] }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-purple-400 hover:text-purple-300 transition">
                                📋 Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Access Cards -->
    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('cashflow') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 card-shadow hover:from-purple-700 hover:to-pink-700 transition">
            <div class="text-3xl mb-4">💸</div>
            <h3 class="text-xl font-bold text-white mb-2">Cash Flow Analysis</h3>
            <p class="text-purple-200">Analisis arus kas mendalam dengan forecasting</p>
        </a>

        <a href="{{ route('tax.planning') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-6 card-shadow hover:from-blue-700 hover:to-cyan-700 transition">
            <div class="text-3xl mb-4">🧾</div>
            <h3 class="text-xl font-bold text-white mb-2">Tax Planning</h3>
            <p class="text-blue-200">Perencanaan pajak dan perhitungan otomatis</p>
        </a>

        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl p-6 card-shadow">
            <div class="text-3xl mb-4">📈</div>
            <h3 class="text-xl font-bold text-white mb-2">Financial Forecast</h3>
            <p class="text-green-200">Prediksi keuangan 12 bulan ke depan</p>
        </div>
    </div>

    <!-- Business Insights -->
    <div class="mt-8 bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">Business Insights</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-750 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-3">📊 Top Expense Categories</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Operational</span>
                        <span class="text-red-400 font-semibold">42%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Marketing</span>
                        <span class="text-red-400 font-semibold">28%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Salaries</span>
                        <span class="text-red-400 font-semibold">18%</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-750 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-3">🎯 Financial Health</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Profit Margin</span>
                        <span class="text-green-400 font-semibold">28.4%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">ROI</span>
                        <span class="text-green-400 font-semibold">15.2%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Cash Reserve</span>
                        <span class="text-blue-400 font-semibold">3.2 bulan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
