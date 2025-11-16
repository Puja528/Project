@extends('layouts.app')

@section('title', 'Manajemen Tabungan - Fintrack')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Tabungan</h1>
            <p class="text-gray-600 mt-2">Kelola target dan progres tabungan Anda</p>
        </div>
        <a href="{{ route('savings.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Target
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
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-bullseye text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Target</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalTarget, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-piggy-bank text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Terkumpul</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalCurrent, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Progress</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($totalProgress, 1) }}%
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $savings->where('status', 'active')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($savings as $saving)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-3"
                         style="background-color: {{ $saving->color }}20; color: {{ $saving->color }}">
                        <i class="fas fa-{{ $saving->icon }} text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $saving->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $saving->status_badge }}-100 text-{{ $saving->status_badge }}-800">
                            {{ $saving->status_text }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>{{ $saving->current_amount_formatted }}</span>
                    <span>{{ $saving->target_amount_formatted }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-{{ $saving->progress_color }}-600 h-2 rounded-full transition-all duration-300"
                         style="width: {{ $saving->progress_percentage }}%"></div>
                </div>
                <div class="text-right text-sm text-gray-500 mt-1">
                    {{ number_format($saving->progress_percentage, 1) }}%
                </div>
            </div>

            <!-- Details -->
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Sisa:</span>
                    <span class="font-medium">{{ $saving->remaining_amount_formatted }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Target:</span>
                    <span>{{ $saving->target_date->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Sisa Waktu:</span>
                    <span>{{ $saving->days_remaining }} hari</span>
                </div>
                @if($saving->monthly_target)
                <div class="flex justify-between">
                    <span>Bulanan:</span>
                    <span class="font-medium">{{ $saving->monthly_target_formatted }}</span>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('savings.show', $saving->id) }}"
                   class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-sm font-medium transition text-center">
                    <i class="fas fa-eye mr-1"></i> Detail
                </a>
                <a href="{{ route('savings.edit', $saving->id) }}"
                   class="flex-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 px-3 py-2 rounded text-sm font-medium transition text-center">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <i class="fas fa-piggy-bank text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada target tabungan</h3>
                <p class="text-gray-500 mb-4">Mulai rencanakan tabungan Anda untuk mencapai tujuan finansial</p>
                <a href="{{ route('savings.create') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                    Buat target pertama Anda →
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
