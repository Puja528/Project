@extends('layouts.advance')

@section('title', 'Manajemen Anggaran - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Manajemen Anggaran</h1>
        <a href="{{ route('budgets.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Buat Anggaran
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6">
        @foreach($budgets as $budget)
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $budget['category'] }}</h3>
                    <p class="text-gray-400 mt-1">{{ $budget['description'] }}</p>
                    <p class="text-gray-500 text-sm mt-2">Periode: {{ $budget['month_year'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-white">
                        Rp {{ number_format($budget['used_amount'], 0, ',', '.') }}
                    </p>
                    <p class="text-gray-400 text-sm">
                        dari Rp {{ number_format($budget['allocated_amount'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-400 mb-2">
                    <span>Utilization</span>
                    <span>{{ round(($budget['used_amount'] / $budget['allocated_amount']) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    @php
                        $percentage = ($budget['used_amount'] / $budget['allocated_amount']) * 100;
                        $color = $percentage > 90 ? 'bg-red-500' : ($percentage > 75 ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="{{ $color }} h-3 rounded-full" 
                         style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center text-sm text-gray-500">
                <span>Allocated: Rp {{ number_format($budget['allocated_amount'], 0, ',', '.') }}</span>
                <span>
                    Sisa: Rp {{ number_format($budget['allocated_amount'] - $budget['used_amount'], 0, ',', '.') }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Budget Summary -->
    <div class="mt-8 grid md:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-2">Total Anggaran</h3>
            <p class="text-2xl font-bold text-purple-400">
                Rp {{ number_format(array_sum(array_column($budgets, 'allocated_amount')), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-2">Total Digunakan</h3>
            <p class="text-2xl font-bold text-pink-400">
                Rp {{ number_format(array_sum(array_column($budgets, 'used_amount')), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-2">Efisiensi</h3>
            <p class="text-2xl font-bold text-green-400">
                {{ round((array_sum(array_column($budgets, 'used_amount')) / array_sum(array_column($budgets, 'allocated_amount'))) * 100, 1) }}%
            </p>
        </div>
    </div>
</div>
@endsection