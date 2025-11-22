@extends('layouts.advance')

@section('title', 'Analisis Cash Flow - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Cash Flow Analysis</h1>
        <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            🔄 Generate Report
        </button>
    </div>

    <!-- Cash Flow Summary -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Operating Cash Flow</h3>
            <p class="text-2xl font-bold text-green-400 mt-2">Rp 52,500,000</p>
            <p class="text-gray-500 text-sm">Positive</p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Investing Cash Flow</h3>
            <p class="text-2xl font-bold text-red-400 mt-2">Rp -15,000,000</p>
            <p class="text-gray-500 text-sm">Capital Expenditure</p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Financing Cash Flow</h3>
            <p class="text-2xl font-bold text-blue-400 mt-2">Rp 5,000,000</p>
            <p class="text-gray-500 text-sm">Loan Proceeds</p>
        </div>
    </div>

    <!-- Cash Flow Chart -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8">
        <h2 class="text-xl font-bold text-white mb-6">Cash Flow Trend</h2>
        <div class="h-96">
            <canvas id="cashFlowChart"></canvas>
        </div>
    </div>

    <!-- Cash Flow Details -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Operating Activities -->
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">💰 Operating Activities</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Cash from Customers</span>
                    <span class="text-green-400 font-semibold">Rp 185,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Payments to Suppliers</span>
                    <span class="text-red-400 font-semibold">Rp -95,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Employee Payments</span>
                    <span class="text-red-400 font-semibold">Rp -37,500,000</span>
                </div>
            </div>
        </div>

        <!-- Investing & Financing -->
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">🏦 Investing & Financing</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Equipment Purchase</span>
                    <span class="text-red-400 font-semibold">Rp -15,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Loan Received</span>
                    <span class="text-green-400 font-semibold">Rp 10,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Loan Repayment</span>
                    <span class="text-red-400 font-semibold">Rp -5,000,000</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash Flow Forecast -->
    <div class="mt-8 bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">📈 6-Month Cash Flow Forecast</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Projected Income</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Projected Expense</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Net Cash Flow</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cumulative</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Feb 2024</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">Rp 19,200,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">Rp 14,500,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-400">Rp 4,700,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Rp 9,950,000</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Mar 2024</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">Rp 17,800,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">Rp 12,800,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-400">Rp 5,000,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Rp 14,950,000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Cash Flow Chart
    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
    const cashFlowChart = new Chart(cashFlowCtx, {
        type: 'bar',
        data: {
            labels: @json($cashFlowData['labels']),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($cashFlowData['income']),
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                },
                {
                    label: 'Pengeluaran',
                    data: @json($cashFlowData['expense']),
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                },
                {
                    label: 'Net Cash Flow',
                    data: @json($cashFlowData['net']),
                    type: 'line',
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
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