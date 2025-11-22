@extends('layouts.admin')

@section('title', 'Admin Dashboard - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 text-white mb-8 card-shadow">
        <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ session('username') }}! 👑</h1>
        <p class="opacity-90">Anda login sebagai <strong>System Administrator</strong>. Kelola sistem Fintrack.</p>
    </div>

    <!-- System Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <span class="text-2xl">👥</span>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
            </div>
            <p class="text-green-500 text-sm mt-2">{{ $stats['active_users'] }} active users</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <span class="text-2xl">💰</span>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Transactions</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_transactions'] }}</p>
                </div>
            </div>
            <p class="text-blue-500 text-sm mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }} revenue</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <span class="text-2xl">⭐</span>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Standard Users</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['standard_users'] }}</p>
                </div>
            </div>
            <p class="text-purple-500 text-sm mt-2">Basic plan users</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-pink-100 rounded-lg mr-4">
                    <span class="text-2xl">🚀</span>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Advance Users</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['advance_users'] }}</p>
                </div>
            </div>
            <p class="text-pink-500 text-sm mt-2">Business plan users</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- User Growth Chart -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">User Growth</h2>
            <div class="h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Revenue Growth</h2>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl card-shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users') }}" class="bg-blue-50 border border-blue-200 p-4 rounded-lg text-center hover:bg-blue-100 transition">
                <div class="text-2xl mb-2">👥</div>
                <p class="font-semibold text-blue-700">Manage Users</p>
            </a>
            <a href="{{ route('admin.transactions') }}" class="bg-green-50 border border-green-200 p-4 rounded-lg text-center hover:bg-green-100 transition">
                <div class="text-2xl mb-2">💰</div>
                <p class="font-semibold text-green-700">View Transactions</p>
            </a>
            <a href="{{ route('admin.analytics') }}" class="bg-purple-50 border border-purple-200 p-4 rounded-lg text-center hover:bg-purple-100 transition">
                <div class="text-2xl mb-2">📊</div>
                <p class="font-semibold text-purple-700">Analytics</p>
            </a>
            <a href="{{ route('admin.activity-logs') }}" class="bg-red-50 border border-red-200 p-4 rounded-lg text-center hover:bg-red-100 transition">
                <div class="text-2xl mb-2">📝</div>
                <p class="font-semibold text-red-700">Activity Logs</p>
            </a>
        </div>
    </div>

    <!-- System Health -->
    <div class="mt-8 grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">System Health</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Server Status</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Online</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Database</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Healthy</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Last Backup</span>
                    <span class="text-sm text-gray-500">2 hours ago</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    <span class="text-gray-600">New user registered</span>
                </div>
                <div class="flex items-center text-sm">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                    <span class="text-gray-600">System backup completed</span>
                </div>
                <div class="flex items-center text-sm">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                    <span class="text-gray-600">Payment processed</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">System Alerts</h3>
            <div class="space-y-2">
                <div class="flex items-center text-sm p-2 bg-yellow-50 rounded">
                    <span class="text-yellow-600 mr-2">⚠️</span>
                    <span class="text-yellow-700">3 users approaching storage limit</span>
                </div>
                <div class="flex items-center text-sm p-2 bg-blue-50 rounded">
                    <span class="text-blue-600 mr-2">ℹ️</span>
                    <span class="text-blue-700">System update available</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // User Growth Chart
    const userCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userChart = new Chart(userCtx, {
        type: 'line',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [{
                label: 'Total Users',
                data: @json($stats['user_growth']),
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [{
                label: 'Revenue (in millions)',
                data: @json(array_map(function($val) { return $val / 1000000; }, $stats['revenue_growth'])),
                backgroundColor: '#EC4899',
                borderColor: '#EC4899',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue (in millions IDR)'
                    }
                }
            }
        }
    });
</script>
@endsection