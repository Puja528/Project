@extends('layouts.app')

@section('title', 'Tambah Budget - Fintrack')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('budgets.index') }}" class="flex items-center text-purple-600 hover:text-purple-700 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Budget Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori *
                    </label>
                    <select id="category"
                            name="category"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Month Year -->
                <div>
                    <label for="month_year" class="block text-sm font-medium text-gray-700 mb-2">
                        Periode (Bulan-Tahun) *
                    </label>
                    <input type="month"
                           id="month_year"
                           name="month_year"
                           value="{{ old('month_year', date('Y-m')) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                           required>
                    @error('month_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Allocated Amount -->
                <div>
                    <label for="allocated_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Anggaran (Rp) *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number"
                               id="allocated_amount"
                               name="allocated_amount"
                               value="{{ old('allocated_amount') }}"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                               placeholder="0.00"
                               required>
                    </div>
                    @error('allocated_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                              placeholder="Tambahkan deskripsi budget (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('budgets.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium text-center">
                    Simpan Budget
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
