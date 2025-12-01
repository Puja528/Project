@extends('layouts.advance')

@section('title', 'Business Priority Matrix - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-6 text-white mb-8 card-shadow">
        <h1 class="text-2xl font-bold mb-2">Business Priority Matrix 🎯</h1>
        <p class="opacity-90">Kelola prioritas bisnis Anda dengan matrix Eisenhower yang interaktif.</p>
    </div>

    <!-- Matrix Container -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Penting & Mendesak -->
        <div class="bg-red-500/10 border-2 border-red-500 rounded-2xl p-6 card-shadow">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                Penting & Mendesak
            </h2>
            <div class="space-y-3">
                @foreach($matrixData['pentingMendesak'] as $item)
                <a href="{{ route('advance.priority-matrix.detail', $item['id']) }}"
                   class="block bg-gray-800/50 hover:bg-gray-700/70 p-4 rounded-lg transition duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-white">{{ $item['nama'] }}</h3>
                            <p class="text-gray-400 text-sm">{{ $item['jumlah'] }}</p>
                        </div>
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">{{ $item['status'] }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Due: {{ $item['tenggat_waktu'] }}</p>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Mendesak & Tidak Penting -->
        <div class="bg-yellow-500/10 border-2 border-yellow-500 rounded-2xl p-6 card-shadow">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                Mendesak & Tidak Penting
            </h2>
            <div class="space-y-3">
                @foreach($matrixData['mendesakTidakPenting'] as $item)
                <a href="{{ route('advance.priority-matrix.detail', $item['id']) }}"
                   class="block bg-gray-800/50 hover:bg-gray-700/70 p-4 rounded-lg transition duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-white">{{ $item['nama'] }}</h3>
                            <p class="text-gray-400 text-sm">{{ $item['jumlah'] }}</p>
                        </div>
                        <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">{{ $item['status'] }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Due: {{ $item['tenggat_waktu'] }}</p>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Penting & Tidak Mendesak -->
        <div class="bg-blue-500/10 border-2 border-blue-500 rounded-2xl p-6 card-shadow">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                Penting & Tidak Mendesak
            </h2>
            <div class="space-y-3">
                @foreach($matrixData['pentingTidakMendesak'] as $item)
                <a href="{{ route('advance.priority-matrix.detail', $item['id']) }}"
                   class="block bg-gray-800/50 hover:bg-gray-700/70 p-4 rounded-lg transition duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-white">{{ $item['nama'] }}</h3>
                            <p class="text-gray-400 text-sm">{{ $item['jumlah'] }}</p>
                        </div>
                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">{{ $item['status'] }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Due: {{ $item['tenggat_waktu'] }}</p>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Tidak Mendesak & Tidak Penting -->
        <div class="bg-gray-500/10 border-2 border-gray-500 rounded-2xl p-6 card-shadow">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                Tidak Mendesak & Tidak Penting
            </h2>
            <div class="space-y-3">
                @foreach($matrixData['tidakMendesakTidakPenting'] as $item)
                <a href="{{ route('advance.priority-matrix.detail', $item['id']) }}"
                   class="block bg-gray-800/50 hover:bg-gray-700/70 p-4 rounded-lg transition duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-white">{{ $item['nama'] }}</h3>
                            <p class="text-gray-400 text-sm">{{ $item['jumlah'] }}</p>
                        </div>
                        <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded">{{ $item['status'] }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Due: {{ $item['tenggat_waktu'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('advance.budgets.index') }}"
           class="bg-purple-600 hover:bg-purple-700 p-4 rounded-lg text-center transition">
            <div class="text-2xl mb-2">📊</div>
            <p class="font-semibold">Kelola Anggaran</p>
        </a>
        <a href="{{ route('advance.reports.index') }}"
           class="bg-pink-600 hover:bg-pink-700 p-4 rounded-lg text-center transition">
            <div class="text-2xl mb-2">📈</div>
            <p class="font-semibold">Lihat Laporan</p>
        </a>
        <a href="{{ route('transactions.index') }}"
           class="bg-blue-600 hover:bg-blue-700 p-4 rounded-lg text-center transition">
            <div class="text-2xl mb-2">💰</div>
            <p class="font-semibold">Transaksi</p>
        </a>
    </div>
</div>
@endsection
