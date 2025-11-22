@extends('layouts.advance')

@section('title', 'Tambah Investasi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Tambah Investasi Baru</h1>
            <p class="text-gray-400">Tambah instrumen investasi ke portfolio Anda</p>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <form action="{{ route('investments.store') }}" method="POST">
                @csrf
                
                <div class="grid gap-6">
                    <!-- Nama Investasi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nama Investasi *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                               placeholder="Contoh: Saham BBCA, Reksadana X">
                    </div>

                    <!-- Tipe dan Risk Level -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tipe Investasi *</label>
                            <select name="type" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                                <option value="">Pilih Tipe</option>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Risk Level *</label>
                            <select name="risk_level" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                                <option value="">Pilih Risk Level</option>
                                <option value="low">Low Risk</option>
                                <option value="medium">Medium Risk</option>
                                <option value="high">High Risk</option>
                            </select>
                        </div>
                    </div>

                    <!-- Jumlah Investasi -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah Awal (Rp) *</label>
                            <input type="number" name="initial_amount" required min="0"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="10000000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nilai Saat Ini (Rp) *</label>
                            <input type="number" name="current_value" required min="0"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="12500000">
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="start_date" required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('investments.index') }}" 
                       class="px-6 py-3 border border-gray-600 text-gray-300 rounded-lg font-semibold hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Investasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Risk Guide -->
        <div class="mt-6 bg-blue-900 border border-blue-700 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-300 mb-3">Panduan Risk Level:</h3>
            <div class="grid gap-3 text-sm">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                    <div>
                        <strong class="text-green-300">Low Risk:</strong>
                        <p class="text-blue-200">Deposito, Obligasi Negara (Return 3-6%)</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
                    <div>
                        <strong class="text-yellow-300">Medium Risk:</strong>
                        <p class="text-blue-200">Reksadana, Saham Blue Chip (Return 6-15%)</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full mr-3"></span>
                    <div>
                        <strong class="text-red-300">High Risk:</strong>
                        <p class="text-blue-200">Saham Growth, Crypto (Return 15%+)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection