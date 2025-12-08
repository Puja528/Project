@extends('layouts.admin')

@section('title', 'System Analytics - Fintrack Admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">System Analytics 📈</h1>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-gray-500 text-sm font-medium">Active Users</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($analytics['active_users']) }}</p>
                <p class="text-green-500 text-sm mt-2">Total Users: {{ number_format($analytics['total_users']) }}</p>
            </div>
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-gray-500 text-sm font-medium">Last Month Income</h3>
                <p class="text-3xl font-bold text-gray-800">Rp
                    {{ number_format($analytics['monthly_revenue'], 0, ',', '.') }}
                </p>
                <p class="text-gray-500 text-sm mt-2">From Transaction Table</p>
            </div>
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-gray-500 text-sm font-medium">Total Revenue (Kumulatif 6 Bulan)</h3>
                <p class="text-3xl font-bold text-gray-800">Rp
                    {{ number_format(end($analytics['revenue_growth']), 0, ',', '.') }}
                </p>
                <p class="text-gray-500 text-sm mt-2">Revenue Growth Trend</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <div class="bg-white rounded-2xl card-shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Transaction Trend (Income/Expense)</h2>
                <div class="h-64">
                    <canvas id="transactionTrendChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">User Type Distribution</h2>
                <div class="h-64">
                    <canvas id="userTypeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-1 gap-8">
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">User Growth (Cumulative)</h2>
                <div class="h-96">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <script>
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userChart = new Chart(userCtx, {
            type: 'line',
            data: {
                labels: @json($analytics['user_growth_labels']), // Menggunakan label dinamis
                datasets: [{
                    label: 'Total Users (Cumulative)',
                    data: @json($analytics['user_growth']), // Menggunakan data dinamis
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });


        const revenueCtx = document.getElementById('transactionTrendChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($analytics['transaction_trends']['labels']), // Menggunakan label dinamis
                datasets: [
                    {
                        label: 'Income',
                        data: @json(array_map(function ($val) {
                            return $val / 1000000;
                        }, $analytics['transaction_trends']['income'])), // Data Income
                        backgroundColor: '#10B981', // Green for Income
                        borderWidth: 1
                    },
                    {
                        label: 'Expense',
                        data: @json(array_map(function ($val) {
                            return $val / 1000000;
                        }, $analytics['transaction_trends']['expense'])), // Data Expense
                        backgroundColor: '#EF4444', // Red for Expense
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (in millions)'
                        }
                    }
                }
            }
        });


        const typeCtx = document.getElementById('userTypeChart').getContext('2d');
        const typeChart = new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Standard Users', 'Advance Users', 'Admin'],
                datasets: [{
                    data: @json($analytics['user_type_data']), // Menggunakan data dinamis
                    backgroundColor: [
                        '#3B82F6', // Biru untuk Standard
                        '#8B5CF6', // Ungu untuk Advance
                        '#EF4444' // Merah untuk Admin
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
