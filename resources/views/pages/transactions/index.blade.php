@extends('layouts.admin')

@section('title', 'Manajemen Transaksi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Transaksi</h1>
        <a href="{{ route('transactions.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Tambah Transaksi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Eisenhower Matrix Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <h3 class="font-semibold text-red-800">Penting & Mendesak</h3>
            <p class="text-2xl font-bold text-red-600">{{ $transactions->where('eisenhower_category', 'urgent_important')->count() }}</p>
            <p class="text-sm text-red-600">Transaksi</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-800">Penting & Tidak Mendesak</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $transactions->where('eisenhower_category', 'not_urgent_important')->count() }}</p>
            <p class="text-sm text-blue-600">Transaksi</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="font-semibold text-yellow-800">Mendesak & Tidak Penting</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $transactions->where('eisenhower_category', 'urgent_not_important')->count() }}</p>
            <p class="text-sm text-yellow-600">Transaksi</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h3 class="font-semibold text-green-800">Tidak Mendesak & Tidak Penting</h3>
            <p class="text-2xl font-bold text-green-600">{{ $transactions->where('eisenhower_category', 'not_urgent_not_important')->count() }}</p>
            <p class="text-sm text-green-600">Transaksi</p>
        </div>
    </div>

    <div class="bg-white rounded-lg card-shadow overflow-hidden">
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
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $transaction->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->user_name ?? 'System User' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->type === 'income')
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
                            {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $categories[$transaction->category] ?? $transaction->category }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Tombol View -->
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-sm font-medium transition">
                                    View
                                </a>

                                <!-- Tombol Delete -->
                                <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Export Button -->
    <div class="mt-6 flex justify-end">
        <form action="{{ route('export.basic') }}" method="POST">
            @csrf
            <button type="submit"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                📊 Ekspor Data
            </button>
        </form>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
</style>
@endsection
