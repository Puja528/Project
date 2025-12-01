@extends('layouts.advance')

@section('title', 'Portfolio Investasi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Portfolio Investasi</h1>
        <a href="{{ route('advance.investments.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Tambah Investasi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Portfolio Summary -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Investasi</h3>
            <p class="text-2xl font-bold text-white mt-2">
                Rp {{ number_format(collect($investments)->sum('initial_amount'), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Nilai Saat Ini</h3>
            <p class="text-2xl font-bold text-white mt-2">
                Rp {{ number_format(collect($investments)->sum('current_value'), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Return</h3>
            @php
                $totalInitial = collect($investments)->sum('initial_amount');
                $totalCurrent = collect($investments)->sum('current_value');
                $totalReturn = $totalCurrent - $totalInitial;
            @endphp
            <p class="text-2xl font-bold {{ $totalReturn >= 0 ? 'text-green-400' : 'text-red-400' }} mt-2">
                {{ $totalReturn >= 0 ? '+' : '' }}Rp {{ number_format($totalReturn, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Avg Return</h3>
            <p class="text-2xl font-bold text-blue-400 mt-2">
                {{ count($investments) > 0 ? number_format(collect($investments)->avg('return_percentage'), 1) : 0 }}%
            </p>
        </div>
    </div>

    <!-- Tabel Investasi -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8">
        <h2 class="text-xl font-bold text-white mb-6">Daftar Investasi</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-750 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Investasi</th>
                        <th scope="col" class="px-6 py-3">Tipe Investasi</th>
                        <th scope="col" class="px-6 py-3">Risk Level</th>
                        <th scope="col" class="px-6 py-3">Jumlah Awal</th>
                        <th scope="col" class="px-6 py-3">Nilai Saat Ini</th>
                        <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                        <th scope="col" class="px-6 py-3">Return</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investments as $investment)
                    <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-750">
                        <td class="px-6 py-4 font-medium text-white whitespace-nowrap">
                            {{ $investment['name'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-200">
                                {{ $investment['type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $investment['risk_level'] === 'high' ? 'bg-red-900 text-red-200' :
                                   ($investment['risk_level'] === 'medium' ? 'bg-yellow-900 text-yellow-200' : 'bg-green-900 text-green-200') }}">
                                {{ ucfirst($investment['risk_level']) }} Risk
                            </span>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($investment['initial_amount'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($investment['current_value'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ date('d/m/Y', strtotime($investment['start_date'])) }}</td>
                        <td class="px-6 py-4 font-semibold {{ $investment['return_percentage'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $investment['return_percentage'] >= 0 ? '+' : '' }}{{ $investment['return_percentage'] }}%
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                            <div class="text-center py-8">
                                <i class="fas fa-chart-line text-5xl text-gray-600 mb-4"></i>
                                <p class="text-gray-400 text-lg">Belum ada data investasi</p>
                                <p class="text-gray-500 mt-2">Klik "Tambah Investasi" untuk menambahkan investasi pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Asset Allocation Chart Placeholder -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">Asset Allocation</h2>
        <div class="h-64 flex items-center justify-center bg-gray-700 rounded-lg">
            <p class="text-gray-400">Chart: Distribusi Aset Investasi</p>
        </div>
    </div>
</div>
@endsection
