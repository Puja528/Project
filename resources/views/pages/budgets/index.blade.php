@extends('layouts.app')

@section('title', 'Manajemen Budget - Fintrack')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Budget</h1>
            <p class="text-gray-600 mt-2">Kelola anggaran keuangan perusahaan</p>
        </div>
        <a href="{{ route('budgets.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Budget
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Budgets Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terpakai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($budgets as $budget)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $categories[$budget->category] ?? $budget->category }}
                            </div>
                            @if($budget->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($budget->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $budget->month_year)->format('F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $budget->allocated_amount_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                            {{ $budget->used_amount_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            {{ $budget->remaining_amount_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-{{ $budget->usage_percentage > 80 ? 'red' : ($budget->usage_percentage > 60 ? 'yellow' : 'green') }}-600 h-2 rounded-full"
                                         style="width: {{ min($budget->usage_percentage, 100) }}%"></div>
                                </div>
                                <span class="ml-2 text-xs text-gray-500">{{ number_format($budget->usage_percentage, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('budgets.show', $budget->id) }}"
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-sm font-medium transition flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    View
                                </a>
                                <a href="{{ route('budgets.edit', $budget->id) }}"
                                   class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 px-3 py-1 rounded text-sm font-medium transition flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('budgets.destroy', $budget->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus budget ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-sm font-medium transition flex items-center">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <i class="fas fa-chart-pie text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">Belum ada data budget.</p>
                                <a href="{{ route('budgets.create') }}" class="text-purple-600 hover:text-purple-700 mt-2">
                                    Buat budget pertama Anda
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
