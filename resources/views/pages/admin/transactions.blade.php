@extends('layouts.admin')

@section('title', 'Transaction Management - Fintrack Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Transaction Management</h1>
        <div class="flex space-x-4">
            <select class="border border-gray-300 rounded-lg px-4 py-2">
                <option>All Types</option>
                <option>Income</option>
                <option>Expense</option>
            </select>
            <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Export
            </button>
        </div>
    </div>

    <!-- Transaction Stats -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Transactions</h3>
            <p class="text-3xl font-bold text-gray-800">1,250</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Income</h3>
            <p class="text-3xl font-bold text-green-600">Rp 185M</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Expense</h3>
            <p class="text-3xl font-bold text-red-600">Rp 159M</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Avg Transaction</h3>
            <p class="text-3xl font-bold text-blue-600">Rp 275K</p>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-2xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $transaction['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction['user'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction['type'] === 'income')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Income
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Expense
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                            {{ $transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($transaction['amount'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction['category'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction['date'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
