@extends('layouts.advance')

@section('title', 'Hutang & Piutang - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Hutang & Piutang</h1>
        <a href="{{ route('debts.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Tambah Data
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Piutang</h3>
            <p class="text-2xl font-bold text-green-400 mt-2">
                Rp {{ number_format($totalPiutang, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Hutang</h3>
            <p class="text-2xl font-bold text-red-400 mt-2">
                Rp {{ number_format($totalHutang, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Net Position</h3>
            <p class="text-2xl font-bold {{ $netPosition >= 0 ? 'text-green-400' : 'text-red-400' }} mt-2">
                Rp {{ number_format($netPosition, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="grid gap-6">
        @foreach($debts as $debt)
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $debt['person_name'] }}</h3>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $debt['type'] === 'piutang' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                                    {{ $debt['type'] === 'piutang' ? 'Piutang' : 'Hutang' }}
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $debt['status'] === 'active' ? 'bg-blue-900 text-blue-200' : 
                                       ($debt['status'] === 'paid' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200') }}">
                                    {{ ucfirst($debt['status']) }}
                                </span>
                                @if($debt['interest_rate'] > 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-200">
                                    Bunga: {{ $debt['interest_rate'] }}%
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold 
                                {{ $debt['type'] === 'piutang' ? 'text-green-400' : 'text-red-400' }}">
                                Rp {{ number_format($debt['amount'], 0, ',', '.') }}
                            </p>
                            <p class="text-gray-400 text-sm">Jatuh Tempo: {{ $debt['due_date'] }}</p>
                        </div>
                    </div>

                    @if($debt['description'])
                    <p class="text-gray-400 mb-4">{{ $debt['description'] }}</p>
                    @endif

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Initial: Rp {{ number_format($debt['initial_amount'], 0, ',', '.') }}</span>
                        @if($debt['status'] === 'active' && $debt['due_date'] < date('Y-m-d'))
                        <span class="text-red-400 font-semibold">OVERDUE</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if(count($debts) === 0)
    <div class="text-center py-12">
        <div class="text-6xl mb-4">💳</div>
        <h3 class="text-xl font-semibold text-gray-400 mb-2">Belum ada data hutang/piutang</h3>
        <p class="text-gray-500 mb-6">Kelola hutang dan piutang bisnis Anda</p>
        <a href="{{ route('debts.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            Tambah Data Pertama
        </a>
    </div>
    @endif
</div>
@endsection