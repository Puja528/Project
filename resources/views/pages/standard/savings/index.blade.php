@extends('layouts.standard')

@section('title', 'Target Tabungan - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Target Tabungan</h1>
        <a href="{{ route('savings.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Target Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6">
        @foreach($savings as $saving)
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $saving['name'] }}</h3>
                    <p class="text-gray-600 mt-1">{{ $saving['description'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-purple-600">
                        Rp {{ number_format($saving['current_amount'], 0, ',', '.') }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        dari Rp {{ number_format($saving['target_amount'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress</span>
                    <span>{{ round(($saving['current_amount'] / $saving['target_amount']) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full" 
                         style="width: {{ ($saving['current_amount'] / $saving['target_amount']) * 100 }}%">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center text-sm text-gray-500">
                <span>Target: {{ $saving['target_date'] }}</span>
                <span>
                    Sisa: Rp {{ number_format($saving['target_amount'] - $saving['current_amount'], 0, ',', '.') }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if(count($savings) === 0)
    <div class="text-center py-12">
        <div class="text-6xl mb-4">💰</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada target tabungan</h3>
        <p class="text-gray-500 mb-6">Mulai rencanakan masa depan finansial Anda</p>
        <a href="{{ route('savings.create') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            Buat Target Pertama
        </a>
    </div>
    @endif
</div>
@endsection