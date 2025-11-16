@extends('layouts.admin')

@section('title', 'Activity Logs - Fintrack Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">System Activity Logs</h1>
        <div class="flex space-x-4">
            <select class="border border-gray-300 rounded-lg px-4 py-2">
                <option>All Actions</option>
                <option>User Management</option>
                <option>System Changes</option>
                <option>Security Events</option>
            </select>
            <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Export Logs
            </button>
        </div>
    </div>

    <!-- Log Statistics -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Logs</h3>
            <p class="text-3xl font-bold text-gray-800">1,248</p>
            <p class="text-gray-500 text-sm mt-2">This month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Admin Actions</h3>
            <p class="text-3xl font-bold text-blue-600">892</p>
            <p class="text-gray-500 text-sm mt-2">71% of total</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Security Events</h3>
            <p class="text-3xl font-bold text-red-600">23</p>
            <p class="text-gray-500 text-sm mt-2">Requires attention</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Avg Daily Logs</h3>
            <p class="text-3xl font-bold text-green-600">42</p>
            <p class="text-gray-500 text-sm mt-2">Per day</p>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-white rounded-2xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log['created_at'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $log['admin'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $log['action'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log['description'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log['ip_address'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(str_contains($log['action'], 'failed') || str_contains($log['action'], 'denied'))
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    High
                                </span>
                            @elseif(str_contains($log['action'], 'login') || str_contains($log['action'], 'access'))
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Medium
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Low
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Security Alerts -->
    <div class="mt-8 bg-red-50 border border-red-200 rounded-2xl p-6">
        <h2 class="text-xl font-bold text-red-800 mb-4">🚨 Security Alerts</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-red-100 rounded-lg">
                <div>
                    <h3 class="font-semibold text-red-800">Multiple Failed Login Attempts</h3>
                    <p class="text-red-600 text-sm">IP: 192.168.1.105 - 5 failed attempts in 10 minutes</p>
                </div>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Investigate
                </button>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-100 rounded-lg">
                <div>
                    <h3 class="font-semibold text-yellow-800">Unusual Activity Detected</h3>
                    <p class="text-yellow-600 text-sm">User access from unusual location</p>
                </div>
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Review
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
