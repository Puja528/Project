@extends('layouts.advance')

@section('title', 'Detail Priority - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('advance.priority-matrix') }}"
           class="inline-flex items-center text-purple-400 hover:text-purple-300 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Priority Matrix
        </a>
    </div>

    <!-- Detail Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-2xl p-8 card-shadow border border-gray-700">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $item['nama'] }}</h1>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($item['prioritas'] == 'Tinggi') bg-red-500 text-white
                            @elseif($item['prioritas'] == 'Sedang') bg-yellow-500 text-white
                            @else bg-gray-500 text-white @endif">
                            Prioritas: {{ $item['prioritas'] }}
                        </span>
                        <span class="px-3 py-1 bg-purple-500 text-white rounded-full text-sm font-medium">
                            {{ $item['kuadran'] }}
                        </span>
                    </div>
                </div>
                <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-sm font-medium">
                    {{ $item['status'] }}
                </span>
            </div>

            <!-- Detail Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-gray-400 text-sm font-medium mb-1">Jumlah</h3>
                        <p class="text-2xl font-bold text-white">{{ $item['jumlah'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm font-medium mb-1">Tenggat Waktu</h3>
                        <p class="text-lg text-white">{{ $item['tenggat_waktu'] }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-gray-400 text-sm font-medium mb-1">Kategori</h3>
                        <p class="text-lg text-white">{{ $item['kategori'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm font-medium mb-1">ID Item</h3>
                        <p class="text-lg text-white">#{{ $item['id'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h3 class="text-gray-400 text-sm font-medium mb-3">Deskripsi</h3>
                <p class="text-white text-lg leading-relaxed bg-gray-700/50 p-4 rounded-lg">
                    {{ $item['deskripsi'] }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg text-white font-semibold transition">
                    Edit Item
                </button>
                <button class="bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg text-white font-semibold transition">
                    Tandai Selesai
                </button>
                <button class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg text-white font-semibold transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
