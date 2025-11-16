@extends('layouts.admin')

@section('title', 'System Analytics - Fintrack Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">System Analytics</h1>

    <!-- Key Metrics -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Active Users</h3>
            <p class="text-3xl font-bold text-gray-800">142</p>
            <p class="text-green-500 text-sm mt-2">+12% from last month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Monthly Revenue</h3>
            <p class="text-3xl font-bold text-gray-800">Rp 18.5M</p>
            <p class="text-green-500 text-sm mt-2">+8% from last month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Conversion Rate</h3>
            <p class="text-3xl font-bold text-gray-800">4.2%</p>
            <p class="text-green-500 text-sm mt-2">+0.3% from last month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Avg Session</h3>
            <p class="text-3xl font-bold text-gray-800">8.5m</p>
            <p class="text-red-500 text-sm mt-2">-0.2m from last month</p>
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
            <h2 class="text-xl font-bold text-gray-800 mb-6">Revenue Trend</h2>
            <div class="h-64">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- User Demographics -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- User Types -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">User Distribution</h2>
            <div class="h-64">
                <canvas id="userTypeChart"></canvas>
            </div>
        </div>

        <!-- Activity Metrics -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Activity Metrics</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Daily Active Users</span>
                        <span>85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Weekly Retention</span>
                        <span>72%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 72%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Feature Adoption</span>
                        <span>68%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 68%"></div>
                    </div>
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
                label: 'Active Users',
                data: @json($analytics['user_growth']),
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

    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [{
                label: 'Revenue (in millions)',
                data: @json(array_map(function($val) { return $val / 1000000; }, $analytics['revenue_growth'])),
                backgroundColor: '#EC4899',
                borderColor: '#EC4899',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // User Type Chart
    const typeCtx = document.getElementById('userTypeChart').getContext('2d');
    const typeChart = new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Standard Users', 'Advance Users', 'Admin'],
            datasets: [{
                data: [120, 30, 1],
                backgroundColor: [
                    '#3B82F6',
                    '#8B5CF6',
                    '#EF4444'
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
