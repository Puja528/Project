@extends('layouts.advance')

@section('title', 'Buat Anggaran - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Buat Anggaran Baru</h1>
            <p class="text-gray-400">Rencanakan anggaran bisnis Anda</p>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf
                
                <div class="grid gap-6">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Kategori *</label>
                        <select name="category" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Periode dan Jumlah -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Periode (YYYY-MM) *</label>
                            <input type="text" name="month_year" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="2024-01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah Alokasi (Rp) *</label>
                            <input type="number" name="allocated_amount" required min="0"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="5000000">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                  placeholder="Deskripsi anggaran (opsional)"></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('budgets.index') }}" 
                       class="px-6 py-3 border border-gray-600 text-gray-300 rounded-lg font-semibold hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Anggaran
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Budgeting -->
        <div class="mt-6 bg-purple-900 border border-purple-700 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-purple-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-purple-300">Tips Budgeting Bisnis</h3>
                    <p class="text-sm text-purple-200 mt-1">
                        Alokasikan 50-60% untuk operational expenses, 20-30% untuk growth & investment, 
                        dan 10-20% untuk contingency fund. Review anggaran bulanan untuk optimalisasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection