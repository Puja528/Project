@extends('layouts.app')

@section('title', 'Manajemen Hutang & Piutang - Fintrack')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Hutang & Piutang</h1>
            <p class="text-gray-600 mt-2">Kelola data hutang dan piutang perusahaan</p>
        </div>
        <a href="{{ route('debts.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Data
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

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-hand-holding-usd text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Hutang</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($debts->where('type', 'hutang')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-file-invoice-dollar text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Piutang</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($debts->where('type', 'piutang')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-clock text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jatuh Tempo</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $debts->where('due_date', '<', now())->where('status', 'active')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-check-circle text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Lunas</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $debts->where('status', 'paid')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Debts Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terbayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($debts as $debt)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $debt->type_badge }}-100 text-{{ $debt->type_badge }}-800">
                                <i class="fas fa-{{ $debt->type === 'piutang' ? 'file-invoice-dollar' : 'hand-holding-usd' }} mr-1"></i>
                                {{ $debt->type === 'piutang' ? 'Piutang' : 'Hutang' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $debt->person_name }}</div>
                            @if($debt->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($debt->description, 30) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $debt->amount_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $debt->paid_amount_formatted }}</div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-green-600 h-1 rounded-full" style="width: {{ $debt->payment_percentage }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ number_format($debt->payment_percentage, 1) }}%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($debt->due_date)->format('d M Y') }}
                            @if($debt->due_date < now() && $debt->status === 'active')
                                <span class="text-red-500 text-xs block">Terlambat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $debt->status_badge }}-100 text-{{ $debt->status_badge }}-800">
                                {{ $debt->status === 'active' ? 'Aktif' : ($debt->status === 'paid' ? 'Lunas' : 'Terlambat') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('debts.show', $debt->id) }}"
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-sm font-medium transition flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    View
                                </a>
                                <a href="{{ route('debts.edit', $debt->id) }}"
                                   class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 px-3 py-1 rounded text-sm font-medium transition flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('debts.destroy', $debt->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <i class="fas fa-file-invoice-dollar text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">Belum ada data hutang/piutang.</p>
                                <a href="{{ route('debts.create') }}" class="text-purple-600 hover:text-purple-700 mt-2">
                                    Tambah data pertama Anda
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
