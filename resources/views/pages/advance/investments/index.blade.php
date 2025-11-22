@extends('layouts.advance')

@section('title', 'Portfolio Investasi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Portfolio Investasi</h1>
        <a href="{{ route('investments.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Tambah Investasi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Portfolio Summary -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Investasi</h3>
            <p class="text-2xl font-bold text-white mt-2">
                Rp {{ number_format(array_sum(array_column($investments, 'initial_amount')), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Nilai Saat Ini</h3>
            <p class="text-2xl font-bold text-white mt-2">
                Rp {{ number_format(array_sum(array_column($investments, 'current_value')), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Return</h3>
            <p class="text-2xl font-bold text-green-400 mt-2">
                +Rp {{ number_format(array_sum(array_column($investments, 'current_value')) - array_sum(array_column($investments, 'initial_amount')), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Avg Return</h3>
            <p class="text-2xl font-bold text-blue-400 mt-2">
                {{ round(array_sum(array_column($investments, 'return_percentage')) / count($investments), 1) }}%
            </p>
        </div>
    </div>

    <div class="grid gap-6">
        @foreach($investments as $investment)
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $investment['name'] }}</h3>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $investment['risk_level'] === 'high' ? 'bg-red-900 text-red-200' : 
                                       ($investment['risk_level'] === 'medium' ? 'bg-yellow-900 text-yellow-200' : 'bg-green-900 text-green-200') }}">
                                    {{ ucfirst($investment['risk_level']) }} Risk
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-200">
                                    {{ $types[$investment['type']] ?? $investment['type'] }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold 
                                {{ $investment['return_percentage'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $investment['return_percentage'] >= 0 ? '+' : '' }}{{ $investment['return_percentage'] }}%
                            </p>
                            <p class="text-gray-400 text-sm">Return</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400">Initial Investment</p>
                            <p class="text-white font-semibold">Rp {{ number_format($investment['initial_amount'], 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Current Value</p>
                            <p class="text-white font-semibold">Rp {{ number_format($investment['current_value'], 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Start Date</p>
                            <p class="text-white font-semibold">{{ $investment['start_date'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Asset Allocation Chart Placeholder -->
    <div class="mt-8 bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">Asset Allocation</h2>
        <div class="h-64 flex items-center justify-center bg-gray-700 rounded-lg">
            <p class="text-gray-400">Chart: Distribusi Aset Investasi</p>
        </div>
    </div>
</div>
@endsection