@extends('layouts.standard')

@section('title', 'Target Tabungan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Target Tabungan</h1>
            <p class="text-gray-600">Kelola tujuan tabungan dan pantau progresnya</p>
        </div>
        <a href="{{ route('standard.savings.create') }}"
           class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition">
            + Tambah Target
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Export Button -->
    <div class="mb-6">
        <form action="{{ route('standard.export.basic') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="export_type" value="savings">
            <input type="hidden" name="start_date" value="{{ date('Y-m-01') }}">
            <input type="hidden" name="end_date" value="{{ date('Y-m-t') }}">
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                📊 Ekspor Data Tabungan
            </button>
        </form>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('standard.savings.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        placeholder="Cari nama, deskripsi...">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Progres</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                        🔍 Terapkan Filter
                    </button>
                    <a href="{{ route('standard.savings.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                        🔄 Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    🎯
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Target</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalTarget, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    💰
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Terkumpul</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalCurrent, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    📈
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Rata-rata Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($averageProgress, 1) }}%</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    ⏱️
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Target Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($savings) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Goals Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($savings as $saving)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $saving->name }}</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('standard.savings.edit', $saving->id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        <form action="{{ route('standard.savings.destroy', $saving->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus target tabungan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>

                <!-- Description -->
                @if($saving->description)
                <p class="text-gray-600 text-sm mb-4">{{ $saving->description }}</p>
                @endif

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Progress</span>
                        <span>{{ number_format($saving->progress_percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full"
                             style="width: {{ $saving->progress_percentage }}%"></div>
                    </div>
                </div>

                <!-- Amount Info -->
                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-500">Terkumpul</p>
                        <p class="font-semibold text-green-600">Rp {{ number_format($saving->current_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Target</p>
                        <p class="font-semibold text-gray-800">Rp {{ number_format($saving->target_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Target Date -->
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>Target: {{ \Carbon\Carbon::parse($saving->target_date)->format('d M Y') }}</span>
                    <span>{{ $saving->progress_percentage >= 100 ? '🎉 Selesai!' : 'Dalam progres' }}</span>
                </div>

                <!-- Days Left -->
                @if($saving->progress_percentage < 100)
                @php
                    $daysLeft = max(0, \Carbon\Carbon::now()->diffInDays($saving->target_date, false));
                @endphp
                <div class="mt-3 text-center">
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                        {{ $daysLeft }} hari lagi
                    </span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">💰</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada target tabungan</h3>
            <p class="text-gray-500 mb-4">Mulai rencanakan tujuan finansial Anda</p>
            <a href="{{ route('standard.savings.create') }}"
               class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                Buat Target Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
