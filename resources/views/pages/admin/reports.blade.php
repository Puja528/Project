@extends('layouts.admin')

@section('title', 'Financial Reports - Fintrack Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Financial Reports</h1>
        <div class="flex space-x-4">
            <select class="border border-gray-300 rounded-lg px-4 py-2">
                <option>All Reports</option>
                <option>Revenue Reports</option>
                <option>User Reports</option>
                <option>System Reports</option>
            </select>
            <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Generate Report
            </button>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Reports</h3>
            <p class="text-3xl font-bold text-gray-800">48</p>
            <p class="text-gray-500 text-sm mt-2">Generated this month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Revenue Reports</h3>
            <p class="text-3xl font-bold text-green-600">12</p>
            <p class="text-gray-500 text-sm mt-2">Most generated</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Avg Report Size</h3>
            <p class="text-3xl font-bold text-blue-600">2.4MB</p>
            <p class="text-gray-500 text-sm mt-2">Per report</p>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl card-shadow overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $report['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report['type'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report['period'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            Rp {{ number_format($report['total_amount'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report['generated_at'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">View</button>
                            <button class="text-green-600 hover:text-green-900">Download</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Report Templates -->
    <div class="bg-white rounded-2xl card-shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Report Templates</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="border border-gray-200 rounded-lg p-6 hover:border-purple-500 transition">
                <div class="text-3xl mb-4">💰</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Revenue Report</h3>
                <p class="text-gray-600 text-sm mb-4">Monthly revenue breakdown by user type and category</p>
                <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-semibold transition">
                    Generate
                </button>
            </div>
            <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-500 transition">
                <div class="text-3xl mb-4">👥</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">User Analytics</h3>
                <p class="text-gray-600 text-sm mb-4">User growth, retention, and engagement metrics</p>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                    Generate
                </button>
            </div>
            <div class="border border-gray-200 rounded-lg p-6 hover:border-green-500 transition">
                <div class="text-3xl mb-4">📊</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">System Health</h3>
                <p class="text-gray-600 text-sm mb-4">System performance and usage statistics</p>
                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition">
                    Generate
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
